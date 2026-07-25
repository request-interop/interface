# Change Log

## 1.1.1

Hygiene release:

- tighten docblock prose per per sibling packages
- refresh meta-files
- update package versions in composer.json
- match version constraints per sibling packages

## 1.1.0

Widen custom types on `request_(cookies|header|server)_array` to use
`array-key`.

## 1.0.0

First stable release.

## 1.0.0-beta1

Added indications from public review.

- Improved language consistency with other *-interops.
- Added `request_*` prefixes on type aliases.
- Added research on creating from superglobals via factory.
- Per research and review, RequestStructFactory::newRequest() now returns an instance based on the current request.
- Per review, renamed `$input` to `$bodyStream`.

## 1.0.0-alpha1

Ready for public review (after a great deal of untagged private review).
