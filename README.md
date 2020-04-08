## Tooling for [MuseScore Issue 303489](https://musescore.org/en/node/303489)

Two quick and dirty scripts to fix xml closing bracket indentations in the MuseScore test suite, 
as well as potentially any other files created before v3.5.0.

> Please don't judge my coding skills by this code 😉

Adjust the file path in the `exec("grep ...")` command in order to use these 
scripts on your local machine or any directory other than `mtest`.

You need a proper \*nix shell (cygwin may work as well) to use those scripts.

### [fix-mscore-xml.php]

Fixes and rewrites XML closing brackets indentation in any files starting with `<?xml` 
that are found in `mtest` (or whatever path you throw at it) recursively.

### [get-mscore-xmlsize.php]

Prints total size of all files starting with `<?xml` that are found in `mtest` 
(or whatever path you throw at it) recursively, in order to help estimate differences before/after.