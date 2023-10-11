# LLVM Project Governance


*   Proposal: [LP-0001](https://github.com/llvm/llvm-www/blob/HEAD/proposals/LP0004-project-governance.md)
* Author(s): [Chris Bieneman](https://github.com/llvm-beanz), [Aaron Ballman](https://github.com/AaronBallman), [Eric Christopher](https://github.com/echristo), [Mehdi Amini](https://github.com/joker-eph/), [Reid Kleckner](https://github.com/rnk/)
* Review Managers: TBD
* Status: WIP


## Introduction

The LLVM project has grown significantly, and the processes we use to make decisions have not evolved to keep pace with the project growth. We struggle to make decisions in a way that is timely and ensures that all contributors have a voice. Our request-for-comment (RFC) email threads and our latest [decision making process](proposals/LP0001-LLVMDecisionMaking.md) aren’t perfect solutions. The former tends to favor the loudest voices, and the latter has a single point of failure (Chris Lattner), and thus cannot scale.

This proposal seeks to address our community challenges by introducing a project governance system that will empower community leaders to make decisions. This framework is inspired by other open source communities with specific considerations for the factors that make our community unique.


## Motivation

As the LLVM community continues to grow, the systemic problems with making decisions reoccur with increased frequency. Whether these are big decisions that happen infrequently like infrastructure shifts or developer policy, or small decisions that happen daily in the course of code reviews or RFC discussions; we struggle as a community to build consensus and make decisions in ways that are inclusive and respectful to all parties involved while prioritizing the health of the project.

The lack of community governance not only impacts our community's ability to make contentious decisions, it stands as a roadblock for resolving other lingering issues. The lack of a process for resolving disagreement causes a state of paralysis in the community for dealing with systemic issues because there is no clear path to resolution.

One such long-term problem is the lack of adequate code ownership. Many parts of the LLVM codebase lack owners or have owners that are way out of date. In our current model, nobody is responsible for auditing and ensuring code ownership. This problem has existed for years because nobody is responsible for it and there is no clear path to resolving it unless a contributor is willing to take on the potentially unpopular task. This root problem causes increasing challenges getting code reviewed as the burden to review falls on a small group of individuals.

## Proposed solution

The goal of this proposal is to codify a structure for how decisions are made and who makes the final decision. This proposal builds on [LP0001 LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md), and assumes that process will be used for contentious decisions. At the core of this proposal is the adoption of consensus-seeking decision making rather than formal consensus methods, and a recognition that decision making isn’t always binary.

This proposal creates structures and bodies to act as decision makers, to provide oversight, and to be responsible for shepherding the community. The new teams take over key roles in [LP0001 LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md). They are also empowered to mediate disputes and given responsibility for supporting the community health of their areas.

This proposal seeks to codify three new structures within the LLVM community:

* Voting Contributors
* Area Teams
* Project Council


### Core Values

This proposal is built on core values that embody the LLVM community culture. Since many of these core values have never been written down or codified, this proposal will attempt to do so to provide background for readers. These values are aspirations. In some areas we may fall short, and sometimes things aren’t always as simple as we wish they were.

We are a _community of peers_. LLVM is an open community where anyone can join and participate. Organizational affiliation does not grant special privileges, we all come here on equal footing. We value diversity and seek to be inclusive to all.

We give _respect freely_, but _authority is earned_. Since we are all peers, everyone in the community deserves and should be given respect. Authority is earned through merit and is fluid; we favor current active participants and we prioritize creating opportunities for newcomers to gain influence.

We expect _public communication_. As an increasingly large and dispersed organization we rely more and more on public and asynchronous communication.

We value _community over code_. We believe that a healthy and strong community can overcome any obstacle, code or otherwise. For this reason we will never sacrifice the health of our community for a technical contribution.

We embrace a _broad definition of contribution_. Throughout this document we talk about contributions and community involvement. The definition of _contribution_ is not limited to just code commits. We value and recognize the many shapes that _contributions_ take.

### Consensus-Seeking Decision Making

The spirit of [LP0001 LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md) is to provide a framework to help the community arrive at a decision around contentious topics. As described the process does not follow a fully democratic process and it acknowledges the possibility that consensus cannot be reached. These are strengths of that proposal process and nothing in this proposal is intended to weaken that.

Formal consensus processes (i.e. voting, surveys, etc) are _extremely_ difficult to execute on decentralized projects like LLVM, and not necessary for healthy community growth. Formal consensus is not a goal.

Consensus-seeking decision making instead focuses on efforts to build consensus and address concerns. It does not require that all concerns are addressed, nor that a full consensus is reached.

This proposal gives decision making authority to project governance structures defined below.


###  Role of Code Owners

This proposal does not change the role of code owners as defined in the [LLVM Developer Policy](https://llvm.org/docs/DeveloperPolicy.html#code-owners). As stated in the policy:

    The sole responsibility of a code owner is to ensure that a commit to their area of the code is appropriately reviewed, either by themself or by someone else.


### Code of Conduct

All participants in the LLVM Community must follow the LLVM Community Code of Conduct. That applies to the representatives of governance bodies just as it does to any other individual in the community. The Code of Conduct Committee can suspend or revoke the privilege of any individual to participate in the LLVM Governance process for violations of the Code of Conduct.

Misconduct in elections or governance roles such as fraudulent voting are violations of the Code of Conduct.


### Voting Contributors

The first structure is to define the _voting contributor_ base. The _voting contributor_ base seeks to represent the active project contributors. In the context of project governance, the only responsibility of a _voting contributor_ is to vote to elect members of the _area teams_.

The LLVM Foundation will maintain a voter database that identifies voters by name, email, and the accounts used on services used by the LLVM project. The voter database will only be used for election-related purposes. A full privacy policy that complies with appropriate laws will be published, and it will include a process for removing your personal information from the voter database. To be a _voting contributor_ an individual must register with the LLVM Foundation voter database, and meet eligibility requirements.

An individual may be deemed ineligible to vote for violations of the community Code of Conduct. Acting fraudulently or any other method of subverting an LLVM election is a violation of the Code of Conduct.

Voter eligibility is based on recent community participation in the form of _meaningful contributions_. A _meaningful contribution_ may be a pull request contribution, or it could be other activities that help the community function like screening issues, moderating community spaces, hosting community events, or participating in code reviews.

7 days before voting begins a list of eligible voters is constructed from the registered voters including only those that have participated in LLVM community interactions in the preceding 12 months.

Using the methodologies defined in Appendix 2, and only looking at the main LLVM repository, we have 1667 eligible _voting contributors_ based on code contributions alone. This number should expand as we incorporate participation in code reviews, issues, and discussion forums.


#### Alternative Considered: Commit Access

Alternatively, the _voting contributor_ base could be defined by commit access. This methodology has two flaws. One is that our commit access list gets stale, and is unwieldy to maintain. The other problem is that with the move to GitHub PRs, commit access is significantly less important. We may begin getting more contributions from users that never bother to request commit privileges.


### Area Teams

The second structure this proposal establishes is a collection of _area teams_. Members of _area teams_ are not required or expected to be experts in the area the team is responsible for. There are no skill or experience requirements to be on an _area team_.

_Area teams_ have three main responsibilities.

First, they are responsible for electing from among themselves a team secretary who will take notes of any team meetings and a team chair who represents the team on the _project council_.

Second, _area teams_ are responsible for maintaining an up-to-date and comprehensive list of code owners for their area of the project. They can nominate any individual they deem appropriate as code owner of any area they are responsible for. The role of _code owner_ remains a volunteer role, and any individual can accept, decline, or resign the role for themselves as they feel appropriate.

Finally, _area teams_ are responsible for facilitating decision making for their area of the project. Facilitating decision making can take any number of forms ranging from contributing to RFC discussions, helping mediate disagreements, or fulfilling roles originally delegated to Chris Lattner in the [LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md) process.

When acting to facilitate decision making the _area team _should act as a mediator between different perspectives helping find common ground and recognizing that decisions need not be binary. The _area team_ should seek to find the best solution to the framed problem, which may not be any of the proposed alternatives. If agreement cannot be reached, the _area team_ may act as the final decision maker. In that capacity decisions of an _area team_ are considered final, but can be overruled by a 2/3 majority vote of the _project council_ or the _area team_ itself revisiting the issue.

_Area teams_ are not intended to be direction setters or primary maintainers of their areas, although individuals on an _area team_ may fulfill that role separately. The _area team’s_ role is as a steward and moderator ensuring the health and smooth operation of the area.

Each _area team_ will have 5 members elected by the _voting contributors_. Candidates for _area teams_ must be a _voting contributor_ and self-nominated. An individual cannot serve on two _area teams_.

Members of an _area team_ are elected for 1 year terms. Individuals are encouraged to not run for more than two consecutive terms. To encourage turnover, incumbent members of an _area team_ must place in the top 4 candidates during an election. The fifth spot will always go to a non-incumbent candidate.


#### Initial Area Teams

With this proposal a group of initial _area teams_ will be formed with defined domain areas. The members of each _area team_ will be defined by an election held after the adoption of the proposal. The initial _area teams_ proposed below are based on statistics generated from the LLVM project repository (See Appendix 2 for applicable scripts).

In dividing the LLVM project into _area teams_, this proposal seeks to break up areas of the project based on contribution volume and number of active contributors. This proposal assumes that areas of the project with more unique contributors are more likely to have contributor disagreements, and that areas with more highly active contributors will be more likely to have diverse _area team_ formations.

This proposal puts a possible set of _area teams_ to form with the specified areas of ownership. One notable point is that LLVM (`:/llvm`) had 945 unique authors contribute over the 12 month period used for statistics. This is far more than any other part of the project, and it justified splitting LLVM into two teams, which are separated as the _LLVM Backend_ and _LLVM Middle-end_. Clang had 706 unique authors, which is also significantly higher than other sub-projects. To represent different parts of the Clang community the _Clang_ and _Clang Tooling_ teams are separated below.

* LLVM Backend (CodeGen, MC, Target)
* LLVM Middle-end (Everything not covered by LLVM Backend)
* Clang (All the `clang` sub-project except tooling and format libraries and tools)
* Clang Tooling (`clang-tools-extra` and the tooling and format libraries from `clang`)
* C/C++ Runtime Libraries (`libcxx`, `libc`, `libunwind`, `libcxxabi`)
* Compiler Runtimes (`compiler-rt`, `openmp`)
* Flang (`flang`)
* MLIR (`mlir`)
* Binary tools (`lldb`, `lld`, `bolt`)
* Incubator (`circt`, `torch-mlir`, `Polygeist`, `clangir`, etc)
* Project Infrastructure (`zorg`, `utils`, `llvm-test-suite`, CI/CD, hosting, etc)
* Community (Discord, Discourse, etc)

##### Community & Infrastructure Area Teams

The _Community_ and _Infrastructure_ _area teams_ have different responsibilities from the other _area teams_ because they aren’t restricted to specific software components of the LLVM project. Their goals are more holistic to provide for the needs of the whole project and wider community.

Both the _community_ and _infrastructure area teams_ will select one member of their team to act as a liaison with the LLVM Foundation. The liaisons will be responsible for managing the relationship between their _area team_ and the employees and directors of the LLVM Foundation.

##### Voting by Area

Every _voting contributor_ is eligible to vote for the project-wide _Community_ and _Infrastructure_ teams. Eligibility for voting on other _area teams_ is determined by _meaningful contributions_ to the areas those teams cover. For example, in order to vote on the **LLVM Backend** _area team_, a contributor would need to contribute code to the LLVM `CodeGen`, `MC`, or `Target` libraries, or to vote on the members of the **Flang** team, a contributor would need to contribute code to the `flang` project. There is no limit to the number of _area teams_ a contributor can vote on if they have made contributions to the relevant areas.

#### Vacancies

A member of an _area team_ can resign at any time. Additionally as life can sometimes happen unexpectedly a member of an _area team_ may be unable to fulfill their duties or resign. In that case a majority of the remaining _area team_ may vote to declare the member removed in absentia after a 90-day absence.

If someone resigns or is otherwise removed from an _area team_, the remaining members of the _area team_ may appoint a replacement to serve the remainder of the term through any process they choose.

A removed member of an _area team’s_ full term is counted toward term limits, not just the time served. For an appointed member the time acting counts toward term limits, but should not impair the ability to run and serve two complete concurrent terms, unless they were previously term-limited in which case, being appointed to serve a partial term does not allow for the 1 year break between terms.

### Project Council

The last structure this proposal defines is the _project council_. The _project council_ is composed of the chair from each of the _area teams_.

The _project council_ has a mandate to:

* Prioritize the long term health of the LLVM project and community.
* Shape the community to be accessible, inclusive, and sustainable.
* Maintain the relationship between the LLVM Community and the LLVM Foundation.
* Facilitate seeking consensus among the LLVM Community and _area teams_.
* As a last resort, act as the final decision maker on debates.

The _project council_ has the power to form and dissolve _area teams_. Forming an _area team_ requires a majority vote. Dissolving an _area team_, or altering the boundaries of an _area team_ requires a consenting vote of the chair of the _area team(s)_ being altered and a majority vote of the _project council_.

Representatives to the _project council_ are also term limited. An individual may not serve on the _project council_ for more than two consecutive terms. This limit may also be waived by the _project council_ if and only if the respective team is unable to produce a different representative.

### Role of the LLVM Foundation

The LLVM Foundation is a 501(c)(3) non-profit organization registered in the United States. The LLVM Foundation’s activities are governed by its bylaws and regulated by United States and California laws. LLVM Foundation hosted and sponsored events may also be subject to local laws as applicable. For these reasons, the LLVM Foundation Board is a non-profit corporation board, not a community board.

The LLVM Foundation accepts donations from sponsors and funds a variety of programs supporting the community and project, and controls project assets. Project assets include, but are not limited to, trademarks, web domains, and LLVM-affiliated accounts on platforms.

The LLVM Foundation's core mission is to support the long-term health of the LLVM Project and Community. The LLVM Foundation does not drive the technical direction of the project, although the employees and directors of the LLVM Foundation have often been contributors and leaders in the project.

As the owner of project assets, the Foundation gets the final say when allocating funding or decisions requiring legal oversight. The Foundation can approve or reject requests for funding on any basis it deems appropriate in accordance with applicable laws and policies.

Members of the LLVM Foundation Board and employees of the LLVM Foundation are also members of the LLVM Community, as such they can also fill roles in any of the community structures defined in this proposal.


### Modifications to the LLVM Decision Making Process

The proposal process described in [LP0001 LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md) should be adjusted in the following ways under this governance proposal.

In step [3](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md?plain=1#L60) of the process, in addition to identifying review managers, the proposal will identify the relevant _area team_ to oversee the proposal. If there is no relevant _area team_, or if the decision spans across the domains of multiple _area teams_ the _project council_ will oversee the proposal.

In steps [4](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md?plain=1#L61) and [8](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md?plain=1#L65), the roles designated to Chris Lattner are replaced by the overseeing _area team_ or the _project council_.

## Voting Process

Public notice of any vote will be published on the LLVM discussion forums under the "Elections" topic at least 14 days before voting opens with a schedule for the election. Each election will be open for 14 days. Reminders will be posted on the "Elections" topic at:

* 7 days before voting opens.
* The day voting opens.
* 7 days after voting opens.
* 48 hours before voting closes.
* 24 hours before voting closes.

Voter eligibility will be determined 7 days before voting opens by the rules for defining _voting contributors_. Voting will be executed using a private poll hosted by [Concordcet Internet Voting Service]([https://civs1.civs.us/](https://civs1.civs.us/)). Concordcet uses a ranked choice polling process.

All eligible _voting contributors_ will be contacted via email with instructions on how to vote on the day voting opens.

### Elections

Elections for _area teams_ will be conducted in January of each year. A two week long nomination period will begin the second Monday in January. During the nomination period any _voting contributor_ can nominate themselves or another _voting contributor_ to run for any one _area team_. No individual can run for more than one _area team_ in a single election. Nominations will be recorded publicly for community visibility.

Voting begins the fourth Monday in January and continues for 2 weeks. Election results will be announced no later than the second Monday in February. The term of the newly elected _area team_ begins the first Monday in March. Each _area team_ will meet during the first week in March to elect from themselves the team chair to re-constitute the _project council_.

### Mandatory Voting

To encourage participation in elections voting is considered mandatory. Any _eligible voting contributor_ who does not vote in an election will be ineligible to vote in the next election and their registration will be removed if they do not vote in the next election they are eligible to vote in.

## Amending This Document

This document should be amended through public proposals following the [LP0001 LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md) process. The _project council_ shall serve as the review managers for any proposal to amend this document.

## Impact On Other Projects

This proposal impacts all LLVM projects and all contributors to the LLVM community.

## Frequently Asked Questions

If there were common questions that came up in the pitch phase, please summarize them and what you think the answer is.  Doing so gives you a chance to address them before the formal review starts up, which can lead to a more productive review thread - one that spends less time rehashing points that have already come up.

## Appendix 1: LLVM Community Metrics Methods

This document references some LLVM community metrics. This appendix contains the methodology and tools used to produce the metrics cited above. The metrics are gathered from git metadata with a scoped date range of September 1, 2022 through September 1, 2023. Using a specific date range allows these metrics to be re-generated consistently, however the metrics should be extended to encompass the latest usage patterns when driving decision making.

### git-crawler.py

This script traverses the directories in the LLVM project listing all the authors of commits in the directory once per commit. The script sums up the number of times an authors name appears to produce an approximation of the number of unique authors who have contributed code under a specific sub-directory. The script does not traverse into sub-directories that have less than 50 unique authors, and it skips `test` and `unittests` folders.

The output printed is the number of unique authors that contribute to each directory with 50 or more authors, and a list of the top ten authors that committed to that directory with their number of commits.

```python
#!/usr/bin/env python3

import os
import subprocess
from collections import Counter

def handleDirectory(path):
 path = path.replace(os.getcwd() + '/', ':')
 output = subprocess.check_output(['git', 'log', '--format=%an', '--since=September 1 2022', '--until=September 1 2023', '--', path]).decode('utf-8').splitlines()
 authors = {}
 for line in output:
   if line not in authors:
     authors[line] = 0
   authors[line] += 1
 return authors

results = {}
results[os.getcwd()] = handleDirectory(os.getcwd())
i = 0
for root, dirs, files in os.walk(os.getcwd()):
 i += 1
 if root not in results:
   dirs = []
 toRemove = []
 for dir in dirs:
   if dir == 'test' or dir == 'unittests':
     toRemove.append(dir)
     continue

   path = os.path.join(root, dir)
   results[path] = handleDirectory(path)
   if len(results[path]) < 50:
     toRemove.append(dir)
   else:
     print('%s: %d' % (path, len(results[path])) )
 for dir in toRemove:
   dirs.remove(dir)

for dir in results:
 if not results[dir]:
   continue
 counters = Counter(results[dir])
 high = counters.most_common(10)
 print('%s:' % dir)
 for val in high:
   print('  %s: %d' % (str(val[0]), val[1])) \
````

### Quick Sum Commits by Author for a Directory

In some places a quick listing of the sum of commits per author for a given tree directory is used. In those cases a shorthand command line was used:

```
`git log --pretty="%an" --since="September 1, 2022" --until="September 1, 2023" -- :/llvm/ | sort | uniq -c | sort`
```

In the script above `:/llvm/` can be replaced with any other path inside the repository.

## Appendix 2: 2023 US LLVM Developer Meeting Talk

### Introduction

This section is a summary of the presentation for the 2023 US LLVM Developer Meeting given by myself (Chris Bieneman). This appendix is the only portion of the document written exclusively by myself without extensive peer review and collaboration. Because this appendix is in part a personal account of why I began work on this and the research I conducted along the way it will use first-person language in places.

### Origins

I've been working on LLVM for 10 years. In that time I've both fallen in love with our community and at times been frustrated by it. When we have objective measurements and we agree things are wonderful. When we don't agree, it can be a nightmare. Despite being an enormous project backed by huge corporations who depend on our code, our project infrastructure leaves a lot to be desired.

For years I've discussed problems with decision making, developer policy, infrastructure, and community building. I've met people at developer meetings, work functions, industry nights, meetups, social gatherings, online spaces, and on occasion freak coincidence. Through all these encounters I've met a lot of people who have struggled to love LLVM as I have.

The motivation for this proposal comes from a deep love for our project and our community, but it is not a blind love. Our community has its flaws.

### Purpose of Governance

Open source project governance models define policies and sometimes structures to ensure the smooth operation and long term health of a project. Governance models vary wildly from project to project, but there are common themes.

Governance models establish processes for decision making, delegate responsibilities and authority, and provide systems of oversight and accountability.

### If It Ain't Broke...

Members of our community may look at the many accomplishments of our project and take that as proof that what we're doing is working. This proposal is not meant to undermine the great work going on in the community, but the fact that things are getting done doesn't mean we don't have a problem.

There are lots of efforts in LLVM that take much longer than they need to, or stall out along the way. These lingering unsolved or drawn out problems are a symptom of a greater problem.

Sometimes efforts stall out before they even get underway because the community can't agree on whether something should be done or how it should be done. Other times something gets started but getting code reviewed becomes a road block.

When barriers for contribution become prevalent, or there is significant uncertainty around the community accepting change, people stop contributing. This exhibits itself by increased forking of the project, and fragmentation of the community and technology ecosystem.

While these may look like separate problems, they both have the same root cause. Our community does not have leadership with the responsibility to ensure smooth operations.

### Looking Elsewhere

In thinking about potential solutions to these problems I looked to other communities. There were many common themes I saw across communities, but three communities in particular stood out to me: Apache, Python and Rust.

Apache was interesting to me because it represented a loosely knit group of projects. While I felt that Apache's model was too loosely connected for our purposes they did have a unifying set of values that I felt resonated with our community. The Apache Way defines core community values that each Apache sub-project is required to respect. These values like bind the project contributors together and establish a common ideology.

Python has a governance model that was proposed from within the community through the Python Enhancement Proposal process as PEP 13. It empowers elected leaders to mediate community discussions and have ultimate decision making authority. Python's PEP 13 describes the relationship between Python's elected project leadership and the Python Software Foundation which alleviates tensions between the responsibilities of the community and non-profit foundation. Python's community prioritized diversity and inclusion which is reflected in the governance model.

Rust is interesting both for its direct dependence on LLVM and parallels in community issues. The Rust project receives a great deal of attention from corporate contributions, and tensions over accountability and oversight of the Rust Core Team resulted in a huge upheaval in 2021. Rust's governance model today has a set of teams that are responsible for specific areas of the project, and a "Leadership Council" that oversees the whole project and picks up things that fall through the gaps. The Leadership Council is comprised of representatives of the teams, and prioritizes and delegates issues to other teams.

Both Python and Rust built their governance models around a structured proposal process that is used to help drive decision making. Similar processes show up in a large number of other open source communities and standards bodies.

### Bringing It Together

From Apache I took a core set of values to unify the community and codified them into writing.

From Python I took a system of elected representatives, and a defined relationship between the project governance and non-profit foundation.

From Rust I took a hierarchy of teams that have defined areas of responsibility and a higher level team responsible for oversight.

For LLVM I tried to break down the teams into areas based on rough contribution volume. I codified the wide purview of the LLVM Community Code of Conduct.

I deliberately did not change the role of code owners from what is codified in our Developer Policy. I recognize that our community expects code owners to take a wider role, and we (generally) respect a wider authority for code owners.

Defining and refining the LLVM Developer Policy should be a priority for elected governance.

## Appendix 3: External Sources Reviewed

Below is a partial list of external sources reviewed during the drafting of this document. This list focuses on documents that had significant influence on the proposal as described above. The sources are grouped by the open source project or community they relate to.

### Apache

* “Briefing: The Apache Way,” The Apache Software Foundation, accessed September 15, 2023. [https://www.apache.org/theapacheway/](https://www.apache.org/theapacheway/).

### LLVM

* Chris Lattner, “Introduce a new LLVM process to resolve contentious decisions,” The LLVM Project, last modified February 18, 2023. [https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md).
* “LLVM Developer Policy,” The LLVM Project, last modified September 11, 2023. [https://llvm.org/docs/DeveloperPolicy.html](https://llvm.org/docs/DeveloperPolicy.html).
* Chris Lattner, “The LLVM Foundation,” _The LLVM Project Blog _(blog), April 3, 2014. [https://blog.llvm.org/2014/04/the-llvm-foundation.html](https://blog.llvm.org/2014/04/the-llvm-foundation.html).
* Tanya Lattner, “LLVM Foundation Granted 501(c)(3) Nonprofit Status”, _The LLVM Project Blog_ (blog), Aug 20, 2015. [https://blog.llvm.org/2015/08/llvm-foundation-granted-501c3-nonprofit.html](https://blog.llvm.org/2015/08/llvm-foundation-granted-501c3-nonprofit.html)

### OpenXLA

* “OpenXLA Governance,” The OpenXLA Project, last modified March 21, 2023. [https://github.com/openxla/community/blob/main/governance/GOVERNANCE.md](https://github.com/openxla/community/blob/main/governance/GOVERNANCE.md)

### Python

* “PEP 0 - Index of Python Enhancement Proposals (PEPs),” The Python Core Team, accessed September 15, 2023. [https://peps.python.org/](https://peps.python.org/).
* “PEP 13 - Python Language Governance,” The Python Core Team, accessed September 15, 2023. [https://peps.python.org/pep-0013/](https://peps.python.org/pep-0013/).
* “PEP 8001 - Python Governance Voting Process,” The Python Core Team, accessed September 15, 2023. [https://peps.python.org/pep-8001/](https://peps.python.org/pep-8001/).

### Rust

* “Governance - Rust Programming Language,” The Rust Project, accessed September 15, 2023. [https://www.rust-lang.org/governance](https://www.rust-lang.org/governance).
* “0002-rfc-process.md,” The Rust Project, last modified September 22, 2019. [https://github.com/rust-lang/rfcs/blob/master/text/0002-rfc-process.md](https://github.com/rust-lang/rfcs/blob/master/text/0002-rfc-process.md).
* “3392-leadership-council.md,” The Rust Project, last modified July 26, 2023. [https://github.com/rust-lang/rfcs/blob/master/text/3392-leadership-council.md](https://github.com/rust-lang/rfcs/blob/master/text/3392-leadership-council.md).
* “Add RFC on governance, establishing the Leadership Council,” The Rust Project, accessed September 15, 2023. [https://github.com/rust-lang/rfcs/pull/3392](https://github.com/rust-lang/rfcs/pull/3392).
* “mod team resignation,” The Rust Project, accessed September 15, 2023. [https://github.com/rust-lang/team/pull/671](https://github.com/rust-lang/team/pull/671).


### Other

* Nadia Eghbal, _Managing in Public: The Making and Maintenance of Open Source Software_. Stripe Press, 2020.
