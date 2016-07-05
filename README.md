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
 * @URL ("/homepage")
 * @Logged
 */
public function index() { ... }
```



```php
/**
 * A sample default action that requires to be logged.
 *
 * @URL ("/homepage")
 * @Logged(middlewareName = "myUnauthorizedMiddleware")
 */
public function index() { ... }
```
