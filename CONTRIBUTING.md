# Contributing

Add one independent `.changelog/*.md` fragment for each observable change.
Use [Fast Forward Changelog](https://github.com/php-fast-forward/changelog)
through CPX with PHP 8.5 or newer; the package's PHP requirements stay unchanged.

```sh
cpx --skip-local fast-forward/changelog help add
cpx --skip-local fast-forward/changelog add "Describe the change." --category=fixed --no-interaction
cpx --skip-local fast-forward/changelog check --no-interaction
```

Choose the category and semantic impact that describe the change. Commit the
fragment with the contribution; leave published history intact and do not add
an `Unreleased` section to `CHANGELOG.md`. After committing, validate the PR delta
with `check --since=origin/main --source=github --no-interaction` using the same CLI.

[The installed project skill](.agents/skills/fast-forward-changelog/SKILL.md)
explains the contribution and release lifecycle. Check its integrity with
`cpx --skip-local fast-forward/changelog skill:install --check --json`.
The skill is a local instruction payload, independent of a Composer dependency.

The GitHub workflow checks fragments, maintains PR feedback and prepares a
version PR from stable ancestral tags, existing GitHub Release notes and committed
history. Historical GitHub Release bodies are preserved in `CHANGELOG.md`; empty
release bodies are identified explicitly without invented change descriptions.
New entries can link to their originating PR automatically when GitHub evidence
is available.
Version PR titles use `chore(release): fast-forward/http-client v<current> → v<next>`.
Review that PR's version, history and fragment deletions before merging it.
It never merges itself;
its approved merge publishes the version tag and GitHub Release. Installing the
workflow or merging an ordinary contribution does not publish a release.
