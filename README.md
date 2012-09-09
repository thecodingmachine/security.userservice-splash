Integrating the "userservice" with Splash
=========================================

This package is part of the Mouf PHP framework and contains the *@Logged* annotation to bind with Splash to the UserService.

The <b>@Logged</b> annotation
-----------------------------

This filter can be used in any action. If you put this annotation, the user will be denied access
if he is not logged in.

```php
/**
 * A sample default action that requires to be logged.
 *
 * @URL /homepage
 * @Logged
 */
public function index() { ... }
```

The <b>@Logged</b> annotation requires an instance of UserService to exist. The
name of the instance must be "userService".
If your UserService instance is not named "userService" (or if you want to use several UserService instances,
you can specify the instance of UserService to use in parameter of the annotation:

```php
/**
 * A sample default action that requires to be logged.
 * The "myUserService" Mouf instance will be used to check
 * whether the user is logged or not.
 *
 * @URL /homepage
 * @Logged("myUserService")
 */
public function index() { ... }
```
