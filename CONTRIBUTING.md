# How to contribute to Laraberg

## Reporting issues

When you have an issue with Laraberg there are a few steps you can take to
  increase the probability that it will get picked up as soon as possible:
 
1. Do you think you can fix the issue yourself? Give it a shot! Check out
  [how to set up a development environment below](#setting-up-a-development-environment).
  We're open to any pull requests from small bugfixes to new features. If you're
  not sure that your pull request will be accepted you can contact us through a
  Github issue or through [Gitter](https://gitter.im/VanOns/laraberg) to discuss.
2. Create a Github issue. Make sure to use the issue templates that are
  available. Following those templates makes it easier to pinpoint the issue and
  prevents miscommunication. If your issue does not fit into any of the issue
  templates try to be very specific when describing your issue. Reported issue's
  that consist of only one line of text are very hard to work with.

## Setting up a development environment

Setting up a development environment for Laraberg is not as straightforward as
  it could be.

Laraberg is dependent on the Gutenberg packages from WordPress, and since those
  are currently not available as an easy to install NPM package we have to
  jump through some hoops to make those packages available to Laraberg.

1. Clone Laraberg:
  `git clone git@github.com:VanOns/laraberg.git`
2. Install composer dependencies and build Gutenberg assets:
  `composer update`
3. Install NPM dependencies:
  `npm install`
4. Start development mode  
  `npm run dev`

Now you'll have a local installation of Laraberg that you can use in any Laravel
  project by adding it to your `composer.json`:
 
```json
{
    ...
    "repositories": [
        {
            "type": "path",
            "url": "{path_to_laraberg_directory}"
        }
    ],
    "require": {
        "van-ons/laraberg": "*@dev"
    },
    ...
    "minimum-stability": "dev",
    "prefer-stable": true
}
```
