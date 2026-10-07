# Part 5 — OOP in PHP

These small PHP 8.2 examples show how objects keep valid state and how classes collaborate. Run each file separately from this folder; none needs a database or Composer.

```powershell
C:\xampp\php\php.exe examples\01_encapsulation.php
C:\xampp\php\php.exe examples\02_polymorphism.php
C:\xampp\php\php.exe examples\03_inheritance_traits.php
C:\xampp\php\php.exe examples\04_namespaces_autoload.php
C:\xampp\php\php.exe examples\05_object_features.php
C:\xampp\php\php.exe examples\06_types_enum_attributes.php
C:\xampp\php\php.exe examples\07_magic_access.php
```

| Example | Concepts | Expected output |
| --- | --- | --- |
| `01_encapsulation.php` | Class, object, constructor, private state, methods, readonly property, `final`, exceptions | `Learner has 1250 cents` |
| `02_polymorphism.php` | Interface, implementation, dependency injection, composition, test double | A console notice and `Recorded: 1 notification` |
| `03_inheritance_traits.php` | Abstract class, inheritance, method override, trait, `parent::__construct()` | `rectangle area: 12` |
| `04_namespaces_autoload.php` | Namespace, `use`, autoloading, readonly class | `INV-001: 1999 cents` |
| `05_object_features.php` | `$this`/`self`/`static`, uninitialized property, trait conflict, `__toString`, clone, equality | Identity, trait and shallow-clone observations |
| `06_types_enum_attributes.php` | Union/nullable types, enum, attribute, custom exception, `finally` | Order metadata and handled error |
| `07_magic_access.php` | Guarded `__get()`/`__set()` and typo risk | A rejected misspelled property |

## The video's 30 questions

| # | Interview question | Answer / companion |
| ---: | --- | --- |
| 01 | Class vs object? | A class is the definition; an object is one instance. `01_encapsulation.php` creates an `Account`. |
| 02 | Properties, methods, constructor? | Properties hold state; methods implement behavior; `__construct()` validates initial state. See `Account`. |
| 03 | `$this`, `self::`, `static::`? | Current object, defining class, and late-bound called class. Compare them in `05_object_features.php`. |
| 04 | Public, protected, private? | Public callers; protected class/subclasses; private class only. See `Account` and `Shape`. |
| 05 | Uninitialized typed property? | Reading it raises an `Error`; assign a default or use a nullable property initialized to `null`. See `05_object_features.php`. |
| 06 | Constructor property promotion? | Constructor parameters can declare and assign properties in one step. See `Account::$owner`. |
| 07 | Inheritance with `extends`? | A child inherits accessible members from one parent class. See `Rectangle extends Shape`. |
| 08 | Override and `parent::`? | A child can replace a non-final method and call a parent implementation. `ChildRecord::identity()` calls `parent::identity()`. |
| 09 | Abstract class? | A shared base may implement common behavior and require subclass methods. `Shape::area()` is abstract. |
| 10 | Interface? | It requires public method signatures from implementers. `Notifier` has two implementations. |
| 11 | Trait and conflicts? | A trait shares methods; resolve collisions with `insteadof` and aliases with `as`. See `05_object_features.php`. |
| 12 | Static member? | Use for class-level state or operations unrelated to one object's changing state. See `BaseRecord::$created`. |
| 13 | `final`? | A final class cannot be subclassed; a final method cannot be overridden. `Account` is final. |
| 14 | Encapsulation? | Hide balance and preserve rules in deposit/withdraw methods. See `01_encapsulation.php`. |
| 15 | Polymorphism? | One `Notifier` contract supports multiple concrete behaviors. See `02_polymorphism.php`. |
| 16 | Dependency injection? | Pass a dependency, often through the constructor, instead of creating it inside the service. |
| 17 | Composition vs inheritance? | `RegistrationService` *has a* notifier; `Rectangle` *is a* shape. Choose by relationship. |
| 18 | `readonly`? | A property is assignable during initialization and not reassigned later. It is not deep immutability. See `Invoice`. |
| 19 | `__get()`/`__set()` risks? | Magic access hides fields and can mask typos. `07_magic_access.php` guards allowed names. |
| 20 | `__toString()`? | It supplies a string form of an object; avoid secrets in it. See `DisplayName`. |
| 21 | Clone? | `clone` copies the outer object; referenced nested objects remain shared unless `__clone()` duplicates them. See `Box`. |
| 22 | Object `==` vs `===`? | `==` compares properties/class; `===` means the same instance. See `05_object_features.php`. |
| 23 | Namespace and `use`? | A namespace avoids naming collisions; `use` imports a qualified name. See `Invoice`. |
| 24 | PSR-4 autoload? | Map namespace prefixes to directories and class names to files. `autoload.php` shows a small local mapping. |
| 25 | Custom exceptions? | A named subclass such as `InvalidOrderState` lets callers catch a domain-specific failure. |
| 26 | `try`/`catch`/`finally`? | Catch a handled failure; `finally` runs cleanup whether handling succeeds or fails. See `06_types_enum_attributes.php`. |
| 27 | Union/nullable types? | `int|string` accepts either; `?string` accepts a string or null. See `normalizeReference()`. |
| 28 | Enum? | Use fixed named cases instead of scattered status strings. See `OrderStatus`. |
| 29 | Attribute? | `#[Attribute]` defines structured metadata inspected with reflection. See `Label`. |
| 30 | Testing behind an interface? | Inject a fake `Notifier` and assert recorded messages. See `RecordingNotifier`. |

## Interview points

- **Class vs object:** A class defines structure and behavior; an object is an instance with its own state. `new Account('Learner')` creates one instance.
- **Encapsulation:** Keep invariants behind methods. `Account` does not expose a writable balance, so callers cannot skip the deposit and withdrawal rules.
- **Visibility:** `public` is part of the calling contract; `private` belongs to the class; `protected` is also visible to subclasses. Prefer the narrowest visibility that works.
- **Constructor and type declarations:** A constructor establishes a valid object. Strict scalar types, property types, return types and domain checks solve different problems: `int` does not mean *positive*.
- **Inheritance vs composition:** `Rectangle` *is a* `Shape`; `RegistrationService` *has a* `Notifier`. Use inheritance for a genuine subtype and composition for collaboration.
- **Abstract class vs interface vs trait:** An abstract class can hold shared state and implementation; an interface declares a contract; a trait copies reusable methods into a class. A class can implement several interfaces, but extends at most one class.
- **Polymorphism:** Code typed to `Notifier` can work with either `ConsoleNotifier` or `RecordingNotifier` without changing the service. Injecting the dependency makes this behavior easy to test.
- **`static`, `final`, `readonly`:** Static members belong to a class rather than a particular object. `final` stops subclassing/overriding. A readonly property can be assigned during initialization but not later; an object referenced by a readonly property may still be mutable.
- **Exceptions:** Throw for invalid construction or operations, catch at an application boundary where a useful response is possible, and never expose private traces in an HTTP response.
- **Namespace and autoload:** A namespace separates class names; an autoloader maps names to files. The local `autoload.php` is educational. In a larger project, use Composer's PSR-4 autoloader and commit `composer.json`/lockfile as appropriate.

Common mistakes: making every property public; using `float` for money; using inheritance only to reuse a few lines; assuming an interface provides implementation; suppressing an exception without handling it; and treating `readonly` as deep immutability.

References: [PHP classes and objects](https://www.php.net/manual/en/language.oop5.php), [readonly properties](https://www.php.net/manual/en/language.oop5.properties.php), [traits](https://www.php.net/manual/en/language.oop5.traits.php), [enumerations](https://www.php.net/manual/en/language.enumerations.php), [attributes](https://www.php.net/manual/en/language.attributes.php).

Keep learning, keep coding.
