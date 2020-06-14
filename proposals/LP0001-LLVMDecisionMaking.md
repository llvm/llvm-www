## Introduce a new LLVM process to resolve contentious decisions

*   Proposal: [LP-0001](https://github.com/llvm/llvm-www/blob/master/proposals/LP0001-LLVMDecisionMaking.md)
*   Author: [Chris Lattner](https://github.com/lattner)
*   Review Manager: [Chris Lattner](https://github.com/lattner)
*   Status: Accepted June 14, 2020 [[thread](http://lists.llvm.org/pipermail/llvm-dev/2020-June/142250.html)]
*   Review Discussion: [[thread](http://lists.llvm.org/pipermail/llvm-dev/2020-June/142017.html)]
*   Pitch threads: [[1](http://lists.llvm.org/pipermail/llvm-dev/2020-January/138267.html)] [[2](http://lists.llvm.org/pipermail/llvm-dev/2020-May/141810.html)]

## Introduction

The LLVM project is a pretty high functioning collection of individuals spanning many countries, time zones, and who are members of many organizations. It is also an established community which continues to evolve and change to stay vibrant and adapt to new challenges. This combination makes decision making both incredibly important, but also sometimes difficult to finalize, and very ambiguous/frustrating for contributors.  Examples of historically challenging decisions include the introduction of new subprojects, introduction of new social policies, change to core infrastructure like bug review tools or patch review processes, changes to the LLVM Developer Policy, etc.

This proposal describes a way to improve this, focusing on decisions that are "nearly impossible" to make in the LLVM community right now.  It is not intended to change the primary patch review and code owner flow or responsibility, and is not intended to add additional processes to any other existing flow.  It proposes adding an 'escalation' path that makes "nearly impossible" decisions "merely burdensome" by introducing a process to get them decided.  The hope is that this will remove situations where extreme ambiguity turns off contributors and make progress difficult.


## Motivation

Decision making is incredibly important for a large and distributed community, and the challenges we face are not unique. These challenges manifest in many different ways, including for example:



*   RFC's are a well established convention in the LLVM community, but it is often unclear who the decision makers are, particularly when there is controversy.
*   The llvm-dev mailing list is the primary centerpoint of community and policy making, but it gets a lot of normal development traffic.  This means that many affected people miss important policy discussions.
*   Some policy discussions affect downstream users of LLVM, e.g. developers of the Rust compiler, and they are even less likely to read a LLVM internal development list.
*   It is easy to miss important changes because you don't have time to review everything. Even though you technically had a chance to participate, some people have been surprised when some change goes into effect.
*   Sometimes people chime in late with dissent after a decision has been apparently made: this can be frustrating to people who need a decision made, because they aren't sure how to proceed.  We need more clarity on the conclusion of a decision.
*   Sometimes people express a loud voice on discussion threads even if they aren't active contributors, and they can derail discussions. There is no "moderator" for these discussions, and no expectations/bounds for them.
*   The initial discussion phase of a proposal can have lots of back and forth discussions to shape an idea, and the eventual proposal can have significant changes from that initial review.  It would help to formalize various stages of a proposal.
*   Complex changes (e.g. the relicensing project) sometimes take many rounds of iteration, and it can be easy to lose track of where the proposal is and what the history was because it is spread across a high volume mailing list.
*   Code Owners may be faced with a technical decision and not be sure what to do, particularly for highly impactful design decisions - e.g. for core LLVM IR changes. It could be useful to have a formal escalation process for these decisions.

Despite the challenges, it is important to note that many changes are smooth and non-contentious: the LLVM project has many like-minded individuals - we should not add overhead to things that are currently working well. This should be an optional process used by things that are contentious: we shouldn't force every small or unanimous thing into it.


## Some Principles

In the initial discussion of this process, several nice guiding principles were proposed.  While we don't necessarily need to prescribe these mechanically into the written process, it is good to anchor on these in its execution over time.



*   Be inclusive and understanding: the LLVM community is a diverse group of people, from different backgrounds, speaking different languages, and with different priorities.  We get the best outcomes if we pull more people in and allow all voices to be heard - even if they are not core LLVM contributors.
*   Assume good faith: the LLVM community is filled with many talented and passionate people, discussions should be inclusive.
*   Not a voting system: Several people pointed out the challenges of correct representation, avoiding "voting fraud", etc.  While we generally want to maximize community happiness with decisions, numerical systems will fail on close issues.
*   Important to be flexible on all counts: We need written guidelines to set expectations, but they should not be hard or inflexible rules.  They should be guidelines that are adapted if needed on a case-by-case basis.
*   It is better to have a flawed process than no process: we should try things, iterate, and change as needed.
*   The LLVM project and the potential challenges is too big for any individual or fixed set of people to address all possible challenges.  We need a flexible system for resolving debates.


## Proposed Solution

I recommend that we add a new process influenced by those in other communities, e.g. the [Swift Evolution process](https://github.com/apple/swift-evolution/blob/master/process.md), the [Python PEP process](https://www.python.org/dev/peps/pep-0001/), the [Rust RFC process](https://github.com/rust-lang/rfcs), etc. These processes are designed to help guide decision making for high impact language and standard library changes which are often polarizing, ambiguous, and contentious.  Nevertheless, LLVM community needs are different from other communities, so we should adapt them to our needs.

Owing to the need to get things going and the contentious nature of governance, Chris Lattner is taking several specific roles in the process described.  The goal should be to evolve him out of being a single point of failure over time, but this should help get things off the ground so we can learn and iterate on the process.

This process consists of several phases:

1. Start with a normal LLVM RFC using the existing community process to make a decision.  If it can be resolved through normal means, great - no need for additional process.  We expect this to continue to be the common case.
2. If a discussion turns controversial, escalate the RFC into a "proposal pitch", to help frame both sides of the discussion.  This occurs as a "[PITCH]" thread on the llvm-dev mailing list.  The outcome of this discussion is a proposal written up [using this standardized template](LP0000-Template.md).  The pitch phase can be ignored by people who aren't interested in following all of the details of a discussion.
3. A group of either 2 or 4 community members are selected as "Review Managers" to help with the review, aiming to be representative of both sides of an issue.  These people are proposed in the pitch document itself.
4. Chris takes a look, gives high level guidance to improve the quality of the proposal, approves (or suggests changes to) the Review Manager list, and decides whether it makes sense to run.  He will reject proposals that are obviously inappropriate or that can be addressed with lighter-weight processes.
5. A review manager checks the proposal into a directory (llvm/llvm-www/proposals) so it is version controlled.  This allows better tracking over time of the evolution of the discussion and proposal: for an extreme example of how this is useful, see the header on [this Swift proposal](https://github.com/apple/swift-evolution/blob/master/proposals/0258-property-wrappers.md).
6. That review manager starts a thread on llvm-dev using a template (see below) in a new "[PROPOSAL]" thread on llvm-dev.  Formal discussions occur on this thread over a specific time period (selected by the review manager team, depending on the issue) e.g. one or two weeks.
7. The review managers are responsible for facilitating and moderating the discussion - helping to keep the discussion on-topic and civil, without trying to overtly influence the discussion.  They can also raise awareness of the discussion in affected external communities.  They can also make clarifications and minor improvements to the proposal that don't fundamentally alter its nature.
8. When the discussion concludes, Chris and the review managers have a video chat to review the outcome of the discussion.  The goal of this private discussion is to achieve consensus on an outcome between the review managers and Chris, but if that isn't possible, then Chris will tie break. The outcome may be Approve, Deny, Approve with Changes, or to kick it back to the pitch phase for more discussion.
9. A review manager writes up a summary of the outcome and shares that with the community on the llvm-dev.  The outcome is added to the proposal in github to build a history of proposals and their outcomes.

The goal of this is to allow virtually everyone interested in LLVM to participate in the discussion.  The review managers and Chris can weigh this feedback with a goal of being fair, learning from the community, and producing the best outcome for the community at large: there is no voting.


## Review Discussion Template

After checking in the proposal, a review manager starts a new thread on the llvm-dev mailing list.  Please use the following template as a starting point - it should be modified on a case-by-case basis:


    Hello LLVM community,

    The review of "((PROPOSAL NAME))" begins now and runs through 
    ((REVIEW END DATE)). The proposal is [available online](URL of proposal on 
    github).

    Feedback is an important part of the LLVM Proposal process. All review 
    feedback should be either on this thread or, if you would like to 
    keep your feedback private, directly to one of the review managers.

    **What goes into a review?**

    The goal of the review process is to improve the proposal under review 
    through constructive criticism and, eventually, determine the direction of 
    LLVM. When writing your response, here are some questions you might want 
    to answer in your review:

    *   What is your evaluation of the proposal?  What positive or negative 
        implications would accepting this have?
    *   Do you have experience from other communities that relates to this 
        issue and is important to consider?
    *   How involved have you been in the LLVM project?  Frequent contributor, 
        occasional contributor, user of LLVM libraries, user of LLVM-based tools,
        or other?
    *   Self Evaluation: How much effort did you put into your review and how
        knowledgeable are you about this area? For example, a quick reading or an 
        in-depth study?

    In addition to your opinion and thoughts, please include any additional 
    framing that may be useful.

    Thank you,

    -((REVIEW MANAGER NAME))

    Review Manager

## Impact On Other Projects

This proposed process should affect all subprojects and other aspects of the LLVM umbrella that are guided by the community.  We expect this process will be more inclusive to downstream projects, provide more transparency, and overall help build confidence in the LLVM project from its users.

## Frequently Asked Questions

**Q: Should we improve the existing LLVM RFC processes?**

A: Perhaps!  However, this proposal is already a big step - the author believes it is more important to solve a huge hole in the LLVM processes than it is to improve existing processes.  After we get some experience with this proposal, we can consider changing it and changing other existing processes in a subsequent step.


## Alternatives considered

The most obvious alternative is to do nothing: LLVM has survived for 16 years as an open source project without a formal policy, and we aren't doing too badly. On the other hand, there is a reasonable argument that as the community continues to grow that the problem will get even worse over time.

A second alternative is to go with a BDFL model where (e.g.) Chris has to make all the decisions. This has several problems:

*   While Chris would like to participate, he prefers to draw on the wisdom and judgement of other people as well.
*   Chris doesn't know all areas of the LLVM project anymore.
*   Chris could get hit by a bus some day (to be clear, definitely not "plan A"!) and we/you would have to determine a replacement process at that time.
*   Chris overall isn't a fan of this model, and it is unlikely that the community would accept anyone else in such a role.

This proposal above acknowledges these challenges while making sure Chris is involved to help steer and get the process off the ground.

