# Add Bazel Build Configuration to the LLVM Monorepo

*   Proposal:
    [LP-0002](https://github.com/llvm/llvm-www/blob/master/proposals/LP0002-BazelBuildConfiguration.md)
*   Author: [Geoffrey Martin-Noble](https://github.com/gmngeoffrey)
*   Review Managers: [Chris Bieneman](https://github.com/thegreatbeanz),
    [Eric Christopher](https://github.com/echristo),
    [Renato Golin](https://github.com/rengolin),
    [Chris Lattner](https://github.com/lattner),
    [Geoffrey Martin-Noble](https://github.com/gmngeoffrey),
    [Tom Stellard](https://github.com/tstellar)
*   Status: WIP
*   Pitch thread:
    [thread](https://lists.llvm.org/pipermail/llvm-dev/2021-January/147745.html)
*   Previous Discussions
    [1](http://lists.llvm.org/pipermail/llvm-dev/2020-October/146138.html),
    [2](http://lists.llvm.org/pipermail/llvm-dev/2020-November/146670.html)


## Introduction

LLVM has a single supported build system: CMake. All LLVM components are
required to build with CMake. It also has an unsupported
[GN](https://gn.googlesource.com/gn/) build configuration that some developers
maintain for developer use. The
[LLVM Support Policy](http://llvm.org/docs/SupportPolicy.html) formalizes the
different levels of support for components such as this and less involved
examples like editor configurations. Alternative build systems are already
mentioned in the Support Policy, but some community members felt the inclusion
was not thoroughly vetted.

This proposal seeks to add a build configuration for
[Bazel](https://bazel.build) in the LLVM Monorepo under the "peripheral" support
tier. Bazel is a build system focused on distributed hermetic and reproducible
builds. It is used by various projects at Google that depend on LLVM and for
this purpose these projects have created a Bazel build configuration for LLVM,
an open source example of which can be found in the
[llvm-bazel](https://github.com/google/llvm-bazel) repository. Bazel is also
used by other downstream LLVM users, such as
[PlaidML](https://github.com/plaidml/plaidml).

While this proposal focuses on Bazel, it also explicitly acknowledges the
precedent-setting nature of this decision. Since alternative build systems are
already explicitly mentioned in the Support Policy, this does not require any
policy change, but might be used as a reference for future RFCs. A GN build
configuration already exists in tree, but in RFC discussions, some felt that
"two creates a pattern". This proposal therefore seeks to further define when
alternative build systems would or would not be accepted into the LLVM monorepo.

This proposal was discussed in this
[pitch thread](https://lists.llvm.org/pipermail/llvm-dev/2021-January/147745.html).


## Motivation

LLVM is widely used and integrated in various downstream projects. Allowing
alternative build systems in-tree lowers the barrier to entry for these projects
while adding minimal additional support burden to the community at large. It
allows collaboration on these configurations that are directly tied to LLVM and
increases usability of LLVM for downstream projects. Including the build
configurations in tree greatly simplifies the process of selecting the
appropriate version of the configuration for building a given LLVM revision. The
LLVM project also provides a coordination point with neutral governance and
seems like the correct governance to have for a configuration of LLVM itself.


## Proposed solution

A Bazel build configuration for LLVM be checked into the monorepo under
`llvm/utils/bazel` (adjacent to the current GN files at `llvm/utils/gn`. These
build files would undergo normal patch review
([current draft](https://reviews.llvm.org/D90352)).

The Support Policy already clearly outlines the requirements for inclusion in
the peripheral tier, which include an active subcommunity who can demonstrate
their commitment to continued maintenance of the component and an RFC to argue
for its inclusion. This proposal does not seek to change that or open the door
for any unsupported build system, but rather make the case that Bazel build
files meet these requirements.

Addressing the points in the support requirements individually:

> Code in this tier must:
>
> *   Have a clear benefit for residing in the main repository, catering to an
>     active sub-community (upstream or downstream).

A number of projects build LLVM with Bazel (e.g. IREE, TensorFlow, PlaidML).
Google also uses Bazel to build in its internal source repository. This includes
a substantial number of developers and active contributors to LLVM. Adding this
to the monorepo would provide a natural coordination point for these projects
and avoid fragmentation (projects currently have their own copies of the BUILD
files) or Google-centric governance (e.g. signing Google's CLA).

> *   Be actively maintained by such sub-community and have its problems
>     addressed in a timely manner.

We can commit to maintaining and addressing issues with the configuration.
Google has maintained its internal version of this configuration for a few
years.

> Code in this tier must not:
>
> *   Break or invalidate core tier code or infrastructure. If that happens
>     accidentally, reverting functionality and working on the issues offline is
>     the only acceptable course of action. There should be no interaction
>     between the Bazel build configuration and any core code or infrastructure.
> *   Negatively affect development of core tier code, with the sub-community
>     involved responsible for making changes to address specific concerns.

This should not affect development of core tier components. Others have raised
the concern that the existence of an alternative build system might lead to lack
of maintenance for the CMake build system or reduced contributions from those
who use the alternatiee build system. Given that supporting CMake will remain a
requirement and maintenance of a Bazel build system will continue to happen
regardless (just out of tree), I do not expect any significant impact in this
way. Some Googlers, including those on my team, do contribute to CMake
maintenance (e.g.
https://lists.llvm.org/pipermail/llvm-dev/2021-January/147567.html) and I expect
will continue to do so. In fact, less friction in maintaining the Bazel build
files would, I think, make it more likely that build-system-minded folks would
turn their attention to CMake.

> *   Negatively affect other peripheral tier code, with the sub-communities
>     involved tasked to resolve the issues, still making sure the solution
>     doesn’t break or invalidate the core tier.

Similarly, this should have no interaction with other components in the
peripheral tier. The LLVM Bazel build system maintainers will address conflicts
if they arise.

> *   Impose sub-optimal implementation strategies on core tier components as a
>     result of idiosyncrasies in the peripheral component.

We do not expect any negative constraints on normal development of core tiers.
Bazel is stricter about layering, which may help quickly identify layering
issues in incoming commits, which is already a development principle that LLVM
espouses.

> *   Have build infrastructure that spams all developers about their breakages.
>     Build infrastructure will be configured to only notify opted-in
>     developers.
> *   Fall into disrepair. This is a reflection of lack of an active
>     sub-community and will result in removal.

Build bots with accompanying status badges will be prominently linked from the
README. Currently a Linux/Clang build bot exists and can be easily reconfigured
after the code move. Additional build bots can be added based on supported
configurations (likely Windows MSVC and MacOS as early additions).

> Code in this tier should:
>
> *   Have infrastructure to test, whenever meaningful, with either no warnings
>     or notification contained within the sub-community.
> *   Have support and testing that scales with the complexity and resilience of
>     the component, with the bar for simple and gracefully-degrading components
>     (such as editor bindings) much lower than for complex components that must
>     remain fresh with HEAD (such as experimental back-ends or alternative
>     build systems).

Build bot coverage already exists and will be expanded as described above.

> *   Have a document making clear the status of implementation, level of
>     support available, who the sub-community is and, if applicable, roadmap
>     for inclusion into the core tier.

The patch includes a README that should make the support level clear. I am happy
to add additional language or take additional steps to make that more clear
(e.g. adding `unsupported` to the directory path).

> *   Be restricted to a specific directory or have a consistent pattern (ex.
>     unique file suffix), making it easy to remove when necessary.

All configuration is restricted to a single directory and should be trivial to
remove.


## Impact On Other Projects

Downstream projects that rely on other build systems would benefit from being
able to collaborate on build configurations of LLVM using systems other than the
supported LLVM build system (currently CMake).

Additional commit traffic could be noisy. If this becomes a significant problem
it would be necessary to rectify the situation to the satisfaction of the
community. Some mitigations have already been proposed in various discussion
threads.

Similarly, increased commit traffic increases the risk of merge conflicts when
cherry-picking for release. Since there is no expectation that peripheral
components will be functional in releases, these merge conflicts could be
resolved in any arbitrary fashion, which should minimize their cost. If they
nevertheless create a problem, the subcommunity maintaining an alternative
build system would need to adopt technical or policy changes to rectify the
situation when it is brought to their attention.

New additions to the repo increase the size of the LLVM checkout. These
configurations are a tiny fraction of the overall size of LLVM. Comparing the
LLVM 11.0 release to the latest llvm-bazel, the Bazel build configuration would
be about 0.05 % of the overall repository archive, compressed or expanded.


## Frequently Asked Questions

**Q: How does the outcome of this proposal affect the existing GN build
configuration?**

A: Given that GN is already an existing component, the introduction of which
went through the normal RFC process, any alterations to it should be brought
forward and discussed in a separate RFC.


**Q: Why not maintain the build configurations in a separate repo with an LLVM
submodule?**

A: This is certainly *feasible* and is in fact how
https://github.com/google/llvm-bazel works today. It even has some advantages,
like the ability to guarantee that the build configuration passed for a given
commit. It comes with significant complications, however: it requires an
entirely separate contribution process that needs logic to ensure that new
patches be attached to the correct commit. It also complicates fetching the
correct version of the configuration. In particular the Bazel method for
fetching a new archive via
[http_archive](https://docs.bazel.build/versions/master/repo/http.html#http_archive)
does the fetch at build time and caches based on the SHA-256 digest of the
archive. This adds an extra layer of complexity to vending a build configuration
for an LLVM commit because it expects it to remain stable over time.

**Q: Would there be an expectation that the Bazel build is in a good state for
LLVM version branches? If I checkout the git tag for a final LLVM release,
should I be able to expect that the Bazel build system is functional at that
commit?**

No. I think there should be no such expectation. If the community members who
care about the component would like releases to have functioning build files,
they can figure out a way to make this happen that doesn't make releasing harder
for the release manager (e.g. submitting patches to the release branch). I am
not currently aware of anyone who would want to build LLVM with Bazel against a
release (our development against LLVM is very active, so we tend to want HEAD).

**Q: Why not just embed the CMake build in Bazel?**

Bazel theoretically has support for this via
[rules_foreign_cc](https://github.com/bazelbuild/rules_foreign_cc), but this is
an experimental and unsupported project and the last attempt we made to use it
for LLVM was unsuccessful, which is why OSS projects that use LLVM and Bazel
tend to instead have a Bazel configuration for LLVM. Bazel also likes to know
about all sources and is able to parallelize for distributed builds when doing
so, so there are additional benefits for using such a configuration. Finally,
even if embedding CMake were to work, it is likely that internally Google would
continue to use the internal variant of Bazel and would therefore continue to
maintain BUILD files for it. Thus the marginal effort for maintaining the files
in OSS is not as great.

**Q: What are the concrete next steps for Bazel inclusion if this proposal is
accepted?**'

Discussion of the particular implementation would happen as part of patch
review.

## Alternatives considered

LLVM could refuse to accept unsupported build configurations. Users interested
in other build systems would need to continue working out their own solutions.
This would obviously not be catastrophic, but seems like a missed opportunity to
lower the barrier to entry for integrating LLVM into downstream projects.

LLVM could also accept unsupported build configurations, but have them in a
separate repository instead of the monorepo. This helps deal with concerns over
neutral and standard governance of build configurations that matches that of
LLVM itself. It does not alleviate coordination problems contributing to and
fetching these configurations while keeping them tied to specific LLVM commits,
however.
