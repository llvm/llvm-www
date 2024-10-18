# LLVM Project Governance

* Proposal: [LP-0004](https://github.com/llvm/llvm-www/blob/HEAD/proposals/LP0004-project-governance.md)
* Author(s): [Chris Bieneman](https://github.com/llvm-beanz), [Aaron Ballman](https://github.com/AaronBallman), [Eric Christopher](https://github.com/echristo), [Mehdi Amini](https://github.com/joker-eph/), [Reid Kleckner](https://github.com/rnk/)
* Review Managers: [David Blaikie](https://github.com/dwblaikie), [Louis Dionne](https://github.com/ldionne), [Cyndy Ishida](https://github.com/cyndyishida), [Tom Stellard](https://github.com/tstellar)
* Status: WIP

## Introduction

The LLVM project has grown significantly, and the processes we use to make decisions have not evolved to keep pace with the project growth. We struggle to make decisions in a way that is timely and ensures that all contributors have a voice. Our request-for-comment (RFC) [LLVMDiscourse](https://discourse.llvm.org/) threads and our latest [decision making process](proposals/LP0001-LLVMDecisionMaking.md) aren't perfect solutions. The former tends to favor the loudest voices, and the latter has a single point of failure (Chris Lattner), and thus cannot scale.

This proposal seeks to address our community challenges by introducing a project governance system that will empower community leaders to make decisions. This framework is inspired by other open source communities with specific considerations for the factors that make our community unique.

## Motivation

As the LLVM community continues to grow, the systemic problems with making decisions reoccur with increased frequency. Whether these are big decisions that happen infrequently like infrastructure shifts or developer policy, or small decisions that happen daily in the course of code reviews or RFC discussions; we struggle as a community to build consensus and make decisions in ways that are inclusive and respectful to all parties involved while prioritizing the health of the project.

The lack of community governance not only impacts our community's ability to make contentious decisions, it stands as a roadblock for resolving other lingering issues. The lack of a process for resolving disagreement causes a state of paralysis in the community for dealing with systemic issues because there is no clear path to resolution.

One such long-term problem is the lack of adequate maintainer coverage. Many parts of the LLVM codebase lack maintainers or have maintainers that are way out of date. In our current model, nobody is responsible for auditing and ensuring maintainer coverage. This problem has existed for years because nobody is responsible for it and there is no clear path to resolving it unless a contributor is willing to take on the potentially unpopular task. This root problem causes increasing challenges getting code reviewed as the burden to review falls on a small group of individuals.

## Proposed solution

The goal of this proposal is to codify a structure for how decisions are made and who makes the final decision. This proposal builds on [LP0001 LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md), and assumes that contentious decisions go through that process. For the context of this proposal and **[LP0001]**, a contentious decision is one where general agreement is not reached through discussion on [Discourse](https://discourse.llvm.org). At the core of this proposal is the adoption of consensus-seeking decision making rather than formal consensus methods, and a recognition that decision making isn’t always binary.

This proposal creates structures and bodies to act as decision makers, to provide oversight, and to be responsible for shepherding the community. The new teams take over key roles in [LP0001 LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md). They are also empowered to mediate disputes and given responsibility for supporting the community health of their areas.

This proposal seeks to codify three new structures within the LLVM community:

* Voting Contributors
* Area Teams
* Project Council

This proposal is a starting point. The fundamental goal of this proposal is to create a process that instills within our community a structure that allows the community to address existing problems and adapt to unforeseen challenges. If adopted, it should become a living document that evolves as the project and community evolve. This document, [LP0001 LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md), and other community governance documents should evolve through the proposal process.

### Living Document

On adoption this proposal will be a living document. Changes to the process will be proposed through PRs and reviewed through the [Decision Making process](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md). This proposal is not perfect, and should never be assumed to be static or fixed.

Each year, the _project council_ will collect feedback from _area teams_, _maintainers_ and the wider community on what is working, not working, or could be improved. That feedback will be included in an annual report from the _project council_ on the state of the project and community. The report will be shared ahead of each election cycle, and may include proposals to evolve and improve community processes in the coming year.

The _project council_ is strongly encouraged to hold sessions or roundtable discussions at the LLVM Developer Meetings to collect and discuss feedback on the governance process.

### Goals and Non-Goals

The goal of this proposal _is not_ to solve the hard problems. In the absence of a process to make decisions that the community acknowledges problems either don't get solved, or they get solved in ways that fragment the community. Individuals in our community are still upset about decisions made years ago, often more because of how the decision was made rather than the actual outcome.

The goal of this proposal is to create a system that allows our project and community to break through and make decisions in a way that everyone can acknowledge the validity of the result even if they don't agree with it.

### Core Values

This proposal is built on core values that embody the LLVM community culture. Since many of these core values have never been written down or codified, this proposal will attempt to do so to provide background for readers. These values are aspirations. In some areas we may fall short, and sometimes things aren’t always as simple as we wish they were.

We are a _community of peers_. LLVM is an open community where anyone can join and participate. Organizational affiliation does not grant special privileges, we all come here on equal footing. We value diversity and seek to be inclusive to all.

We give _respect freely_, but _authority is earned_. Since we are all peers, everyone in the community deserves and should be given respect. Authority is earned through merit and is fluid; we favor current active participants and we prioritize creating opportunities for newcomers to gain influence.

We expect _public communication_. As an increasingly large and dispersed organization we rely more and more on public and asynchronous communication.

We value _community over code_. We believe that a healthy and strong community can overcome any obstacle, code or otherwise. For this reason we will never sacrifice the health of our community for a technical contribution.

We embrace a _broad definition of contribution_. Throughout this document we talk about contributions and community involvement. The definition of _contribution_ is not limited to just code commits. We value and recognize the many shapes that _contributions_ take.

### Consensus-Seeking Decision Making

The spirit of [LP0001 LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md) is to provide a framework to help the community arrive at a decision around contentious topics. As described the process does not follow a fully democratic process and it acknowledges the possibility that consensus cannot be reached. These are strengths of that proposal process and nothing in this proposal is intended to weaken that.

Formal consensus and majority opinion (i.e. voting, surveys, etc) processes are _extremely_ difficult to execute on decentralized projects like LLVM, and not necessary for healthy community growth. Formal consensus or majority opinion are not goals.

Consensus-seeking decision making instead focuses on efforts to build consensus and address concerns. It does not require that all concerns are addressed, nor that a full consensus is reached. It also does not require a majority approval.

This proposal gives the responsibility for facilitating consensus-seeking and last-resort decision making authority to project governance structures defined below.

### Role of Maintainers

This proposal does not change the role of maintainers as defined in the [LLVM Developer Policy](https://llvm.org/docs/DeveloperPolicy.html#maintainers). Maintainers are the front line for managing smooth operation of contributions and project workflows.

### Code of Conduct

All participants in the LLVM Community must follow the [LLVM Community Code of Conduct](https://llvm.org/docs/CodeOfConduct.html). That applies to the representatives of governance bodies just as it does to any other individual in the community. The [Code of Conduct Committee](https://llvm.org/docs/CodeOfConduct.html#code-of-conduct-committee) can suspend or revoke the privilege of any individual to participate in the LLVM Governance process for violations of the Code of Conduct.

Misconduct in elections or governance roles such as fraudulent voting are violations of the Code of Conduct.

### RFC vs Proposal

Historically LLVM has relied on an informal RFC process. Our project documentation mentions the use of RFCs, but there is no documentation on the RFC process. This can lead to specific ambiguity about community acceptance of RFCs.

A core component of this proposal is a shift to encourage more proposals to use the process defined in [LP0001 LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md). This proposal suggests the following guidance for when to use the Proposal process:

1) Any change to project governance or governance related documents should use the proposal process.
2) Any change to the LLVM developer policy should use the proposal process.
3) Any RFC that has significant community divide which cannot reach resolution informally should use the proposal process.

### Voting Contributors

The first structure is to define the _voting contributor_ base. The _voting contributor_ base seeks to represent the active project contributors. In the context of project governance, the only responsibility of a _voting contributor_ is to vote to elect members of the _area teams_.

To be a _voting contributor_ an individual must be a member of the LLVM GitHub Organization, and either have a public email address on their GitHub profile or have made a commit to the LLVM project using a non-private email address. The email address on the GitHub public profile or retrieved via commit metadata will be used for all election-related communication.

7 days before voting begins a list of eligible voters is generated from the GitHub organization and activity.

> Note: Recent changes to [commit access criteria](https://discourse.llvm.org/t/rfc2-new-criteria-for-commit-access/77110), and [GitHub email requirements](https://github.com/llvm/llvm-project/pull/109318), have enabled a simpler approach. While this approach may not be perfect, it is simpler, and can be fully automated without requiring maintaining databases or OAuth identification verification.

### Area Teams

The second structure this proposal establishes is a collection of _area teams_. Members of _area teams_ are not required or expected to be experts in the area the team is responsible for. There are no skill or experience requirements to be on an _area team_.

_Area teams_ have three main responsibilities.

First, they are responsible for electing from among themselves a team secretary who will take notes of any team meetings and a team chair who facilitates team meetings and represents the team on the _project council_.

Second, _area teams_ are responsible for maintaining an up-to-date and comprehensive list of maintainers for their area of the project. They can nominate any individual they deem appropriate as maintainer of any area they are responsible for. The role of _maintainer_ remains a volunteer role, and any individual can accept, decline, or resign the role for themselves as they feel appropriate.

> Note: This proposal does not change the existing developer policy for maintainer nomination, nor does it give area teams the exclusive ability to nominate maintainers.

Finally, _area teams_ are responsible for facilitating decision making for their area of the project. Facilitating decision making can take any number of forms ranging from contributing to RFC discussions, helping mediate disagreements, or fulfilling roles originally delegated to Chris Lattner in the [LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md) process.

_Area teams_ should prepare a meeting agenda by collecting all the active RFCs in the community or significant disagreements in pull requests. During the team meeting, the _area team_ should try to identify actionable next steps or information to gather so the RFC or pull request can proceed. An _area team_ may escalate to the project council as needed.

When acting to facilitate decision making the _area team_ should act as a mediator between different perspectives helping find common ground and recognizing that decisions need not be binary. The _area team_ should seek to find the best solution to the framed problem, which may not be any of the proposed alternatives. If agreement cannot be reached, the _area team_ may act as the final decision maker. In that capacity decisions of an _area team_ are considered final, but can be overruled by a 2/3 majority vote of the _project council_ or the _area team_ itself revisiting the issue. If an _area team_ cannot reach consensus, it may request the _project council_ to resolve the disagreement.

A fast "no" is often a better outcome than an indefinite "maybe". In recognition of that, an _area team_, when acting as the facilitator of decision making, will publicly communicate a timeline for discussion and decision making. The _area team_ will communicate when a topic is on the agenda for a meeting with sufficient notice for relevant parties to participate.

_Area teams_ are not intended to be direction setters or primary maintainers of their areas, although individuals on an _area team_ may fulfill that role separately. The _area team's_ role is as a steward and moderator ensuring the health and smooth operation of the area.

Each _area team_ will have an odd number of members with a minimum of three (3) members and a maximum of nine (9) elected by the _voting contributors_. Candidates for _area teams_ must be a _voting contributor_ and self-nominated. An individual cannot serve on two _area teams_.

An _area team_ with less than nine members may increase its size up to nine members with a majority vote. The _area team_ may then appoint members to fill any vacancies as normal. If at the beginning of an election there are insufficient candidates to fill all vacancies on an area team, the team size will decrease to the largest odd number that all the candidates can fill. If less than three candidates run for election for an _area team_ the _project council_ will either recruit members or disband the team.

Members of an _area team_ are elected for 1 year terms.

#### Initial Area Teams

This proposal suggests the formation of a small number of _area teams_ based on the most active parts of the project. These _area teams_ will form the initial _project council_ and it will be the _project council's_ responsibility to form additional _area teams_ to meet the project's needs.

* LLVM
* Clang
* MLIR
* Infrastructure
* Community

#### Process for New Area Teams

Any project area that has at least three members interested in forming an _area team_ can request the _project council_ form one. The _project council_ will then consider the needs of the project and determine whether to form a new team or not.

When the _project council_ forms a new area team, the project council will nominate members for the team to serve until the next elections.

##### Community & Infrastructure Area Teams

The _Community_ and _Infrastructure_ _area teams_ have different responsibilities from the other _area teams_ because they aren’t restricted to specific software components of the LLVM project. Their goals are more holistic to provide for the needs of the whole project and wider community.

In addition to a team chair and secretary, both the _community_ and _infrastructure area teams_ will select one member of their team to act as a liaison with the LLVM Foundation. The liaisons will be responsible for managing the relationship between their _area team_ and the employees and directors of the LLVM Foundation. The liaison may be any member of the _area team_ including the chair or secretary.

#### Vacancies

A member of an _area team_ can resign at any time. As life can sometimes happen unexpectedly, a member of an _area team_ may be unable to fulfill their duties or resign. In that case, a majority of the remaining _area team_ may vote to declare the member removed in absentia after a 90-day absence.

If someone resigns or is otherwise removed from an _area team_, the remaining members of the _area team_ may appoint a replacement to serve the remainder of the term through any process they choose.

### Project Council

The last structure this proposal defines is the _project council_. The _project council_ is composed of the chair from each of the _area teams_.

The _project council_ has a mandate to:

* Prioritize the long term health of the LLVM project and community.
* Shape the community to be accessible, inclusive, and sustainable.
* Maintain the relationship between the LLVM Community and the LLVM Foundation.
* Facilitate seeking consensus among the LLVM Community and _area teams_.
* Act as, or delegate to, an _area team_ for all issues that are not covered by an _area team_, or span across multiple project areas.
* As a last resort, act as the final decision maker on debates.

The _project council_ will elect from among themselves a secretary who will take notes of all meetings, a chair who facilitates meetings, and a liaison to the LLVM Foundation to manage the relationship between the _project council_ and the LLVM Foundation.

The _project council_ has the power to form and dissolve _area teams_. Forming an _area team_ requires a majority vote. Any changes to the _area team_ structures must be publicly disclosed including the motivation for the changes. Dissolving an _area team_, or altering the boundaries of an _area team_ requires a consenting vote of the chair of the _area team(s)_ being altered and a majority vote of the _project council_.

If the _project council_ is seeking to dissolve an _area team_ and the chair of that team does not consent, the team may be dissolved with a unanimous vote of the remaining _project council_ members only after consultation with the Code of Conduct Committee to ensure that all project policies are appropriately followed.

Representatives to the _project council_ are also term limited. An individual may not serve on the _project council_ for more than two consecutive terms. This limit may also be waived by the _project council_ if and only if the respective team is unable to produce a different representative.

### Governance Team Meetings

Each _area team_ and the _project Council_ should have two scheduled public meetings per month. The date of the scheduled meetings should be on the LLVM Community Calendar. The calendar invite will have a link to a public meeting agenda. The teams may have non-public meetings for discussion, deliberation, planning or other purposes. The team may cancel a meeting if no items are on the agenda or to accommodate member schedules (holidays, personal time, etc).

Notes from all _area team_ and _project Council_ meetings will be publicly posted. Notes will exclude reference to any private information, or information that otherwise needs to be confidential.

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

Any _voting contributor_ can vote for members of any _area team_. Voting is not mandatory, and _voting contributors_ may abstain from any individual vote or election at their discretion.

> Note: Concordcet Internet Voting Service suggested here is a placeholder. A more through review of voting systems needs to be conducted. This will overlap with voter registration data collection.

All eligible _voting contributors_ will be contacted via email with instructions on how to vote on the day voting opens.

### Elections

The LLVM Foundation will act as a facilitator for community elections. The LLVM Foundation will maintain a voter registration database in compliance with local and international privacy laws. The LLVM Foundation will publish a privacy policy relating to the voter registration system.

Elections for _area teams_ occur in January of each year. A two week long nomination period begins the second Monday in January. During the nomination period any _voting contributor_ can nominate themselves or another _voting contributor_ to run for any one _area team_. No individual can run for more than one _area team_ in a single election. An individual nominated for more than one area team will be responsible for choosing which team they want to run for. Nominations will be recorded publicly for community visibility. Unsuccessful results in an election do not impact nomination eligibility in subsequent elections.

Voting begins the fourth Monday in January and continues for 2 weeks. Election results will be announced no later than two days after voting closes. The term of the newly elected _area team_ begins the first Monday in March. Each _area team_ will meet during the first week in March to elect from themselves the team secretary and chair to re-constitute the _project council_.

## Amending This Document

This document should be amended through public proposals following the [LP0001 LLVM Decision Making](https://github.com/llvm/llvm-www/blob/main/proposals/LP0001-LLVMDecisionMaking.md) process. The _project council_ shall serve as the review managers for any proposal to amend this document.

## Impact On Other Projects

This proposal impacts all LLVM projects and all contributors to the LLVM community.

## Timeline for Initial Implementation

The initial implementation will have the schedule as listed below:

* December 2, 2024 - Voter identification scripts will be published for review
* December 9, 2024 - Voter identification test 1
* December 16, 2024 - Voter identification test 2 (optional)
* January 6, 2025 - Voter identification test 3 (optional)
* January 13, 2025 - Area Team nominations begin
* January 27, 2025 - Voting opens
* February 10, 2025 - Voting closes
* February 11, 2025 - Results announced on Discourse

The voter identification tests will involve running the voter identification scripts to identify all eligible voting contributors and sending an email notification to the identified email addresses. A post will be made on Discourse after each round of emails are sent to notify contributors to find the sent messages. Tests will be run through December 2024 and the first week of January 2025 to verify smooth identification of voters.

The _project council_ will meet in August 2025 and discuss the governance process. They will collect feedback on how the process has gone in the initial months of implementation and prepare a session for the 2025 US LLVM Developer Meeting to discuss that feedback and any proposed changes.

## Frequently Asked Questions

### Why create new structures instead of expanding the role of code owners?

> Note: Between the time of drafting this document and its acceptance the role of "code owner" was replaced by "maintainer". This section in the FAQ is intentionally left unmodified, however much of its content still applies directly to the maintainer role. For more information about the maintainer role please see the [discourse post](https://discourse.llvm.org/t/rfc-proposing-changes-to-the-community-code-ownership-policy/80714).

The role of code owners divides the community today. The official developer policy describes the role narrowly, but community convention often assumes code owners have more responsibility and authority. This is not a bad thing. This is consistent with LLVM's core value that _authority is earned_. Code owners do a lot of work for the project and the most active code owners earn a greater degree of authority than the role provides. The important distinction here is that the authority comes not from the role of being a code owner, but from the merit of the contributions and efforts of the individual. This creates an obvious challenge because not all code owners contribute equally, and in fact some code owners are inactive entirely.

One key part of this proposal is a belief that we do not have enough code owners as the role is defined today. It is unclear that adding more authority and responsibilities to the role will increase participation or decrease hurdles for new code owners. As [Aaron Ballman](https://github.com/AaronBallman) [pointed out in the review thread](https://github.com/llvm/llvm-www/pull/54#issuecomment-1984269881) that some code owners are expressing being overwhelmed with the current responsibilities of code ownership. Having governance be a separate role that people opt into for a limited term is a way to help avoid contributing to burn out of our code owners.

A second important argument for having new roles is that the new roles rely on a different system for empowerment. Code owners today draw their authority from the merit of their contributions and a nomination system with an intentionally low bar, but not one that is always inclusive. The responsibility of a code owner is to facilitate the maintenance of a defined technical component or area. None of these mean that a given code owner is a person that the community wants facilitating decision making for larger community issues. As we look at issues that impact the whole community like this proposal, proposals related to source control or other project infrastructure, or significant changes to the developer policy, while it is certainly true that code owners will have important feedback, it isn't as clear that they should make the decisions.

### Why is the LLVM Foundation forcing another change on the community?

There has been a perception that this proposal comes from the LLVM Foundation exerting its will on the community. That could not be further from the truth. While members of the LLVM Foundation board are driving this and deeply invested in this proposal, the proposal did not come out of the LLVM Foundation. In fact, it was iterated on and circulated with all the co-signed authors before it was shared with the LLVM Foundation Board.

The LLVM Foundation is a stakeholder for this proposal. The proposal requires that the LLVM Foundation facilitate elections, and it seeks to define some aspects of the relationship between the Foundation and the Community.

Please keep in mind that the LLVM Foundation Board is comprised of individuals, and that one of the most important qualifications for someone to be on the LLVM Foundation Board is that they care deeply for the LLVM project and community. All of the members of the board care deeply about the health and prosperity of the LLVM project and community. All of the members of the board are also individuals who donate their time to supporting the project and community.

Adopting this proposal requires community buy-in. It cannot and will not be forced by the Foundation.

### Why should we allow non-technical people to be on area teams?

This proposal is not advocating that _area teams_ be composed of people with no technical background or that members not be technical leaders. The sentence in the proposal that sparks this question is:

> There are no skill or experience requirements to be on an _area team_.

Taken with no context this seems to be saying we could end up with _area teams_ filled with people who know nothing about the project, but the context is important.

Members of area teams are elected by _voting contributors_, who in turn are individuals who contribute to the project. The individuals contributing to the project are overwhelmingly highly technical and extremely intelligent. This proposal assumes that placing faith in our community to elect decision makers is a safe bet. Given that assumption, and a core value of inclusivity, adopting explicitly inclusive language seems to be the right approach.

## Appendix 1: LLVM Community Metrics Method

This document references some LLVM community metrics. This appendix contains the methodology and tools used to produce the metrics cited above. The metrics are gathered from git metadata with a scoped date range of September 1, 2022 through September 1, 2023. Using a specific date range allows these metrics to be re-generated consistently, however the metrics should be extended to encompass the latest usage patterns when driving decision making.

**These scripts are not intended to drive voter eligibility.** These scripts computed data that informed the formation of _area teams_, but the data is severely limited and insufficient for application to voter eligibility.

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
   print('  %s: %d' % (str(val[0]), val[1]))
```

### Quick Sum Commits by Author for a Directory

In some places a quick listing of the sum of commits per author for a given tree directory is used. In those cases a shorthand command line was used:

```
git log --pretty="%an" --since="September 1, 2022" --until="September 1, 2023" -- :/llvm/ | sort | uniq -c | sort
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

> Note: Since original publication the role of code owner has been redefined as maintainers to encompass the broader community role. See the [discourse post](https://discourse.llvm.org/t/rfc-proposing-changes-to-the-community-code-ownership-policy/80714).

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
