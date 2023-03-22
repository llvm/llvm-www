# Rename `flang-new` to `flang`

*   Proposal: [LP-0003](link to the file on github when it lands)
*   Author(s): [Brad Richardson](https://github.com/everythingfunctional), [Damian Rouson](https://github.com/rouson)
*   Review Managers: [Brad Richardson](https://github.com/everythingfunctional), [Damian Rouson](https://github.com/rouson), [Steve Scalpone](https://github.com/sscalpone), [Peter Klausler](https://github.com/klausler)
*   Status: Active review (3-22-23 .. 4-5-23)

_During the review process, add the following fields as needed:_

*   Pitch Thread: [Initial Discussion](https://discourse.llvm.org/t/reviving-rename-flang-new-to-flang/68130) [Pitch Thread](https://discourse.llvm.org/t/pitch-rename-flang-new-to-flang/68665)
*   Decision Notes:
*   Previous Revision:

## Introduction

The current status of the driver for Flang is that it is named `flang-new`, and requires specifying the (undocumented) flag `-flang-experimental-exec` in order for it to produce an executable.
It is proposed to change this such that `flang-new -flang-experimental-exec` can be used as just `flang`.

## Motivation

For background, prior discussions on the topic can be found in a [recent Discourse thread](https://discourse.llvm.org/t/reviving-rename-flang-new-to-flang/68130), an [older Discourse thread](https://discourse.llvm.org/t/rename-flang-new-as-flang/62571), and a [patch submitted](https://reviews.llvm.org/D125788) nearly a year ago.
A [new patch](https://reviews.llvm.org/D143592) has also been submitted, but has received no reviews or comments yet.

The motivation is that there are interested parties who would like to start trying out flang to see what it’s capabilities might be so far with respect to their codes.
Thus far status updates for the project have not been particularly well publicized, have been relatively vague, and generally unclear, meaning the most direct assessment would come from just trying it.
The current status means that they must either apply the proposed patch themselves or clearly explain to their users how to actually use it.
These artificial barriers to use are exclusionary, are preventing the project from getting useful early feedback, are turning potential contributors away and giving potential new users a bad impression and poor experience.

## Proposed Solution

A [patch](https://reviews.llvm.org/D143592) has been submitted to make the necessary change.
The patch renames the driver from `flang-new` to `flang`, and removes the requirement for the flag `-flang-experimental-exec` to proceed with generating an executable.
Doing this as a single step means that existing users will need to change anything relying on the current name and flag only once, and the sooner the change is made the fewer people will be impacted (we have fewer users now than there will be later).

## Impact on Other Projects

This should have no impact on other LLVM projects, and will mean that any existing users of flang will finally be able to use it in the way it has always been expected and will be expected to be used going forward.

## Frequently Asked Questions

### Could this potentially turn new users away forever for whom the features they need from flang are not yet ready?

Discussions have addressed this concern as likely unfounded, and actually that there is potential it could actually encourage contributions from new users and drive engagement with a new community.
Also, the current state is already giving potential new users a bad experience, so if such an experience was going to turn someone away forever, it likely already has.

### Who will address new bug reports and feature requests as new users begin to try it out?

A team has offered to respond to new issues and serve as liaisons to the flang user community.

## Alternatives Considered

* Wait longer: The argument is that it is not ready for real users, and making this change could imply unrealistic expectations for new users.

* Do this in phases, or as build options: The idea here would be that we gradually make it easier for more “advanced” users to try things out, so as not to overwhelm the current developers with feedback from new users all at once.

Neither of these alternatives would be ideal, as previously explained.