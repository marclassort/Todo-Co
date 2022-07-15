# Technical documentation

This document allows future developers on this app to contribute to the project.  

## Using a versioning tool (Git & GitHub)

To contribute, developers must first contact the project manager, who will integrate them into the team on GitHub. 

This project works from development branches via Git and GitHub, meaning that we'll have a main branch which contains the latest official version of the application, and related development branches. Developers who want to work on a feature, for example on the authentication part, will have to:

* Create a new branch locally on Git (git branch auth)
* Change branch (git checkout auth)
* Make their commits on this branch (git add . / git commit -m "Comments to make for the commit")
* Push the branch to GitHub (git push origin auth)
* On GitHub, ask a pull request to the senior developers.

Once these procedures are done, the project manager in connection with the senior developer will validate or not the changes, and then perform the merge between the new functionalities of the development branch and the main branch. Then, the development branch can be safely deleted. The collaboration is therefore carried out while respecting the developments of each person, and the merge to the main branch is done by the more experienced developers who are also responsible for the security and the durability of the project. 

## Naming conventions

During this project, the naming conventions must also be respected:
 
* For CRUD (create, view, edit, delete) in the methods: createSomething() for creation, readSomething() for consultation, updateSomething() for edition, deleteSomething() for deletion
* Class constants must be named in ALL_CAPS ;
* Classes and interfaces must be named following the PascalCase ;
* Finally, functions, methods and variables must follow the camelCase rule. 

It is also necessary to respect the new rules of PHP 8, by not using annotations but attributes for our controllers and our entities.

## Coding styles
* Open the brackets by returning to the line for the functions
* Open the brackets without returning to the line for if & else statements
* Do not exceed 80 characters per line, and return to the line in the case of parameters of a function, in case of length, for all the lines of an array for example
* Do not close the `<?php` tag if there is only PHP code
* Add a space after the namespace declaration
* Declare visibility on all properties and functions (public, private, etc.)

## Process for tests
* Install PHPUNit: `composer require phpunit/phpunit`
* Write functional tests in *tests\App\Controller* and unitary tests in *tests\App\Entity*
* Run tests: `vendor/bin/phpunit`
* Run code coverage tests and reports: `vendor/bin/phpunit --coverage-html web/code-coverage`