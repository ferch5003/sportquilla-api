# Sportquilla

API for Sportquilla app.

# Installation

Run the Composer install command from the Terminal:

    composer install

After that use:

    php artisan passport:client --personal

And then the following command:

    php artisan migrate:refresh

# Usage

To run locally usethe following command:

    php artisan serve

Available routes:

    +--------+-----------+-----------------------------------------+-----------------------------------+---------------------------------------------------------------------------+--------------+
    | Domain | Method    | URI                                     | Name                              | Action                                                                    | Middleware   |
    +--------+-----------+-----------------------------------------+-----------------------------------+---------------------------------------------------------------------------+--------------+
    |        | GET|HEAD  | /                                       |                                   | Closure                                                                   | web          |
    |        | GET|HEAD  | api/cancha                              |                                   | App\Http\Controllers\API\FieldController@showPlaces                       | api          |
    |        | POST      | api/cancha                              | cancha.store                      | App\Http\Controllers\API\FieldController@store                            | api          |
    |        | DELETE    | api/cancha/{cancha}                     | cancha.destroy                    | App\Http\Controllers\API\FieldController@destroy                          | api          |
    |        | PUT|PATCH | api/cancha/{cancha}                     | cancha.update                     | App\Http\Controllers\API\FieldController@update                           | api          |
    |        | GET|HEAD  | api/cancha/{cancha}                     | cancha.show                       | App\Http\Controllers\API\UserController@details                           | api,auth:api |
    |        | GET|HEAD  | api/user                                |                                   | Closure                                                                   | api,auth:api |
    |        | POST      | api/usuario/login                       |                                   | App\Http\Controllers\API\UserController@login                             | api          |
    |        | POST      | api/usuario/registro                    |                                   | App\Http\Controllers\API\UserController@register                          | api          |
    |        | PATCH     | api/usuario/{id}                        |                                   | App\Http\Controllers\API\UserController@update                            | api          |

