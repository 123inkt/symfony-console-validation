
# Upgrade guide

## From version 1.x to 2.0

Update all usages of `InputConstraint`

**Before**
```php
new InputConstraint(['arguments' => ..., 'options' => ...]);
```

**After**
```php
new InputConstraint(arguments: ..., options: ...);
```
