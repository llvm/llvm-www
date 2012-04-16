#include "llvm/Pass.h"
#include "llvm/Function.h"
#include "llvm/Module.h"
#include "llvm/Instructions.h"
#include "llvm/Constants.h"
#include "llvm/GlobalVariable.h"
#include "llvm/Support/IRBuilder.h"
#include "llvm/ADT/StringMap.h"
#include "llvm/Analysis/LoopInfo.h"
#include "llvm/Transforms/Utils/BasicBlockUtils.h"
#include "llvm/DefaultPasses.h"
#include <string>

using namespace llvm;
using std::string;
using std::pair;

namespace 
{
  class MemoiseExample : public ModulePass {
    /// Module that we're currently optimising
    Module *M;
    /// Static cache.  
    llvm::StringMap<GlobalVariable*> statics;
    // Lookup - call plus its argument
    typedef std::pair<CallInst*,std::string> ExampleCall;
    bool runOnFunction(Function &F);
    public:
    static char ID;
    MemoiseExample() : ModulePass(ID) {}
    virtual bool runOnModule(Module &Mod);
  };
  RegisterPass<MemoiseExample> X("example-pass", 
          "Memoise example pass");
}
char MemoiseExample::ID;

static void removeTerminator(BasicBlock *BB) {
  TerminatorInst *BBTerm = BB->getTerminator();
  // Remove the BB as a predecessor from all of  successors
  for (unsigned i = 0, e = BBTerm->getNumSuccessors(); i != e; ++i) {
    BBTerm->getSuccessor(i)->removePredecessor(BB);
  }
  BBTerm->replaceAllUsesWith(UndefValue::get(BBTerm->getType()));
  // Remove the terminator instruction itself.
  BBTerm->eraseFromParent();
}

bool MemoiseExample::runOnFunction(Function &F) {
  bool modified = false;
  SmallVector<ExampleCall, 16> Lookups;

  for (auto &i : F) {
    for (auto &b : i) {
      if (CallInst *c = dyn_cast<CallInst>(&b)) {
        if (Function *func = c->getCalledFunction()) {
          if (func->getName() == "example") {
            ExampleCall lookup;
            GlobalVariable *arg= dyn_cast<GlobalVariable>(
                c->getOperand(0)->stripPointerCasts());
            if (0 == arg) { continue; }
            ConstantDataArray *init = dyn_cast<ConstantDataArray>(
                arg->getInitializer());
            if (0 == init || !init->isCString()) { continue; }
            lookup.first = c;
            lookup.second = init->getAsString();
            modified = true;
            Lookups.push_back(lookup);
          }
        }
      }
    }
  }
  for (SmallVectorImpl<ExampleCall>::iterator i=Lookups.begin(), 
      e=Lookups.end() ; e!=i ; i++) {
    llvm::Instruction *lookup = i->first;
    std::string &arg= i->second;
    Type *retTy = lookup->getType();
    GlobalVariable *cache = statics[arg];
    if (!cache) {
      cache = new GlobalVariable(*M, retTy, false,
          GlobalVariable::PrivateLinkage, Constant::getNullValue(retTy),
          "._cache");
      statics[arg] = cache;
    }
    BasicBlock *beforeLookupBB = lookup->getParent();
    BasicBlock *lookupBB = SplitBlock(beforeLookupBB, lookup, this);
    BasicBlock::iterator iter = lookup;
    iter++;
    BasicBlock *afterLookupBB = SplitBlock(iter->getParent(), iter, this);
    // SplitBlock() adds an unconditional branch, which we don't want.
    // Remove it.
    removeTerminator(beforeLookupBB);
    removeTerminator(lookupBB);

    PHINode *phi = PHINode::Create(retTy, 2, arg, afterLookupBB->begin());
    // We replace all of the existing uses with the PHI node now, because
    // we're going to add some more uses later that we don't want
    // replaced.
    lookup->replaceAllUsesWith(phi);

    // In the original basic block, we test whether the cache is NULL,
    // and skip the lookup if it isn't.
    IRBuilder<> B(beforeLookupBB);
    llvm::Value *cachedClass =
      B.CreateBitCast(B.CreateLoad(cache), retTy);
    llvm::Value *needsLookup = B.CreateIsNull(cachedClass);
    B.CreateCondBr(needsLookup, lookupBB, afterLookupBB);
    // In the lookup basic block, we just do the lookup, store it in the
    // cache, and then jump to the continue block
    B.SetInsertPoint(lookupBB);
    B.CreateStore(lookup, cache);
    B.CreateBr(afterLookupBB);
    // Now we just need to set the PHI node to use the cache or the
    // lookup result
    phi->addIncoming(cachedClass, beforeLookupBB);
    phi->addIncoming(lookup, lookupBB);
  }
  return modified;
}
bool MemoiseExample::runOnModule(Module &Mod) {
  statics.empty();
  M = &Mod;
  bool modified = false;

  for (auto &F : Mod) {

    if (F.isDeclaration()) { continue; }

    modified |= runOnFunction(F);
  }

  return modified;
};
