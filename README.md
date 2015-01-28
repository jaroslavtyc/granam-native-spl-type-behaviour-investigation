Investigation of behaviour of the [PHP SPL types](http://php.net/manual/en/book.spl-types.php) extension, [version 0.4](http://pecl.php.net/package-changelog.php?package=SPL_Types&release=0.4.0).

(The fastest way to enable that mode on Linux Ubuntu and its derivatives is by
```bash
sudo php5enmod spl_types
```

- before that you need to compile or download and set the extension
)

####SplType

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
    - constructor $initial_value can **not** be (throws **UnexpectedValueException**)
        - true (its strange, but true)
        - object
        - closure
        - resource

####SplString

- constants
    - \_\_default = '' (empty string)
- methods
    - \_\_construct($initial_value = self::\_\_default, $strict = true)
    
- specifics
    - constructor $initial_value can be only string in strict mode; non-string in strict mode always cause UnexpectedValueException or InvalidArgumentException
    - constructor $initial_value can be following values (paired with result) in non-strict mode; de facto it is the standard "to string" cast
        - null => ''
        - false => ''
        - true => '1'
        - string => string
        - integer => (string) integer
        - float => (string) float
    - constructor $initial_value should not be if in non-strict mode; de facto it is the standard "to string" cast
        - array => 'Array' + *notice* **Array to string conversion**
    - constructor $initial_value **never** can be in any mode (cause *notice* **Object of class [class] to string conversion** and throws **InvalidArgumentException**)
        - object
        - closure
        - resource
