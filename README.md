## About Laravel Hybrid

This boilerplate is helpful for any Laravel web application or
backend application. It will speed up your work and make your 
life easier. It will set up almost all basic packages like 
passport, horizon, edujugon/push-notification, laravel/socialite, 
twilio/sdk, predis/predis, facade/ignition, and so on.

In addition to that, it will provide, authentication API, web authentication, and also provides a beautiful admin dashboard. If you need
any custom modification, you can do it very quickly.

Some explanation about code pattern:

- **[Request](#)**
```
    How to make request class for validation?
    
    For Api: php artisan make:request Api/TestRequest
    For Web: php artisan make:request Web/TestRequest
    
    Example code:
    
    public function rules(): array {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
             ......
        ];
    }
    
    /**
     * @return array
     */
    public function messages(): array {
        return [
            'email.required' => __('Email field can not be empty'),
            'email.email' => __('Invalid email address'),
            'password.required' => __('Password field can not be empty'),
            'password.min' => __('Password length must be at least 8 characters.'),
            'password.confirmed' => __('Password and confirm password is not matched'),
             .......
        ]; 
    }

Controller
    How to make controller class?
    For Api:  php artisan make:controller Api/TestModule/TestController
    
    Example code:
    
     /**
     * @param TestRequest $request
     * @return JsonResponse
     */
    public function testMethod(TestRequest $request): JsonResponse {
        return response()->json($this->testService->testFunction($request));
    }
    
    For Web:  php artisan make:controller Web/TestModule/TestController
    
    public function testMethod(TestRequest $request): RedirectResponseAlias {
        return $this->webResponse($this->testService->testFunction($request), 'redirect route name');
    }
    
    About webResponse method:
    
        webResponse(
            array $serviceResponse, 
            string $successRoute = null, 
            string $failedRoute = null,
            array $successRouteParameter = [], 
            array $failedRouteParameter
        )
    
    In controller class, we does not write our bussiness logic, it will 
    just receive the request and pass the response.
```
- **[Service](#)**
```
    In Service class, we only write our business logic, then 
    return the required data to the controller class.

    How to make a service class?
    $ php artisan make: service TestService
    
    This command will create a service class and also create a template. You only need
    a few lines of code. If you don't comfortable with the template then 
    you can easily write your own method for the service class.
    
    In the service class, we can use a special method 
    called response.
    
    
    public function someFunc($request_data) {
        // process data
        // if have some other thing to do
        // Anything save to data on database call Repository class
        ......
        if anythin went wrong:
            return $this->response()->error();
        
        return $this->response()->success();     
    }
    
    If you need to send any data, pass in the response method,
    return $this->response($data)->error();
    
    If want to send any success message send a success message.
    return $this->response($data)->success("something is created successfully");
    
    Similarly to send any error message send in the error method.
    return $this->response($data)->error("any error message you want to write");
    
    If we only use it as 
    return $this->response($data)->error();
    By default the error message will be something went wrong.
    
    If you want to customize the default error message or other things,
    checkout on "ResponseService" in App\Http\Services\Boilerplate dir.  
```
- **[Repository](#)**
```
    If you need to query anything on the database, write the function on 
    repository class.
    
    In our boilerplate, all repository classes inherited abstract
    BaseRepository class. BaseRepository class provides lots of
    query methods that we use most frequently. Besides if you need
    to write a new query, you will write on the repository class.
    
    You can create a Repository class by running the artisan command.
    
    $ php artisan make: repository TestRepository
    
    In the service class, use the repository class as,
    
    $updateTestResponse = $this->testRepository->updateWhere(
                ['id' => $request->test_id],
                $this->updatedData
            );
    If you need to write any customer query write as,
    
    public function getUserLatestResetCode (int $userId) {
    
        return $this->model::where(
            ['user_id' => $userId, 'status' => PENDING_STATUS])
            ->orderBy('id', 'desc')
            ->first();
    }
```

```
Purpose:
--------
# I had to do all this every time I start a Laravel project.
# To install all packages, and set up the project directory structure, writing the
  basic code from scratch is overwhelming.
# I want my life to be easier.

```

```
Future improvement:
-------------------
1. Add more features to this boilerplate
2. Release this boilerplate for different Laravel versions.
```

```
Requirements:
-------------
1. PHP >= 7.2.5 and also php extension
2. composer

```
To know about all dependency of php extension check [Laravel documentation](https://laravel.com/docs/7.x/installation).


```
Installation:
--------------
1. Lets go to the directory where you want to keep your project.

2. Then run the below command from the terminal:
$ git clone "https://github.com/famid/laravel-hybrid.git"

3. Then run:
$ composer install

4. create a .env file and set these variables. likes APP_NAME, database credentials

5. Lastly, run a few commands:

$ php artisan key: generate
$ php artisan migrate
$ php artisan db: seed

If you need to implement API, then run the below command.
$ php artisan passport: install

If you need to implement a queue, then 
set credentials of Redis database on .env file and run 
$ php artisan horizon: install

6. To run the application locally, run:

$ php artisan serve

7. To login Admin Dashboard, use the below credentials:
email: admin@gmail.com
password: 1234

Happy Coding!!! And feel free to contribute to this boilerplate.
```
