[![Build Status](https://travis-ci.org/severinkaderli/Kuro.svg)](https://travis-ci.org/severinkaderli/Kuro)
# Kuro
Simple PHP-Framework for PHP7 build for personal use.
##Features
* Router
  * Supports all important HTTP Methods.
  * Multiple Methods per route definition are possible.
  * Callback can be either a Controller-Method or a Closure.
* Todo:
  * The current Request and Response classes are more for internal routing uses. Maybe they should be called routeRequest and routeResponse. But a  HTTP Request class would be a good idea for a project. HttpRequest & HttpResponse. That could be used for api calls to an url using cUrl i.e.. Then I could make that Script a dependecy in Kuro, because it's something that I could for different projects.
* Coming: DatabaseConnection & Model
* Unit-Tested
