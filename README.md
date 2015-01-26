Investigation of behaviour of the [PHP SPL types](http://php.net/manual/en/book.spl-types.php) extension, [version 0.4](http://pecl.php.net/package-changelog.php?package=SPL_Types&release=0.4.0).

SplType

- constants
    - \_\_default = null
- methods
    - \_\_construct($initial_value = self::\_\_default, $strict = true)
    
- specifics
    - constructor $initial_value can be
        - null
        - false
        - string
        - integer
        - float
        - array
    - constructor $initial_value can **not** be
        - true
        - object
        - closure
        - resource
