# Contributing


## Core Development Discussion
You may propose new features or improvements of existing CodeSpecs behavior in the GitHub issue board. If you propose a new feature, please be willing to implement at least some of the code that would be needed to complete the feature.

We have a [Discord server](https://discordapp.com/) where you can ask any questions, suggest improvements or just to talk with community and developers. [Here is an invitation to the server](https://discord.gg/Ez5VZhC) 

## Contributing flow
If you found a bug and want to report it, want to change something in codebase or have great idea fo improvement - create GitHub issue.
There are two places you can create issue:
- [CodeSpecs](https://github.com/php-kitchen/code-specs/issues) issue tracker - for PHPUnit integration issues
- [CodeSpecsCore](https://github.com/php-kitchen/code-specs-core/issues) issue tracker - for all of the issues

We encourage pull requests, not just bug reports and feature requests. "Bug reports" may also be sent in the form of a pull request containing a failing test.

However, if you file a bug report, your issue should contain a title and a clear description of the issue. You should also include as much relevant information as possible and a code sample that demonstrates the problem. The goal of a bug report is to make it easy for yourself - and others - to replicate the bug and develop a fix.

Remember, bug reports are created in the hope that others with the same problem will be able to collaborate with you on solving it. Do not expect that the bug report will automatically see any activity or that others will jump to fix it. Creating a bug report serves to help yourself and others start on the path of fixing the problem.

## Security Vulnerabilities
If you discover a security vulnerability within CodeSpecs, please send a message to Dmitry Kolodko in Discord or an email at prowwid@gmail.com. All security vulnerabilities will be promptly addressed.

## Code style
We follow follows the [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding standard and the [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) autoloading standard with few additions:
- open bracket should be on the same line with control statement (if () {, function doSmth() { etc.)
- interfaces kept in `Contract` namespace and do not include `I`, `Interface` or other kinds of prefixes
- directories, classes and methods organized by Single Responsibility Principle
- PHP 7 type hints should be always everywhere is possible except of PHPDoc type hints
- method names should be self-explained in the way you won't need a PHPDoc comment

## Commit message format 
We follow strict commit message format when dealing with issue. Commit message should always have following template:
```
{id}: 

----
{summary}
https://github.com/php-kitchen/code-specs/issues/{id}
```

Read more about [Managing tasks and contexts](https://www.jetbrains.com/help/phpstorm/managing-tasks-and-contexts.html) in PHPStorm.