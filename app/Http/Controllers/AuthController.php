<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout','register']]);
    }

    public function register(Request $request)
    {
        $validatedData =$this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6|max:255',
            'delivery_address'=>'required',
            'profile_pic' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
        ]);

        $validatedData['password'] = Hash::make($request->password);
        $uniqueId = uniqid();
        $image = $request->file('profile_pic');
        // Handle file upload
        if ($request->hasFile('profile_pic')) {
            // Generate a unique filename by appending the unique ID to the original filename
            $filename = 'image_'. $uniqueId . '.' . $image->getClientOriginalExtension();

            // Store the image in the storage directory
            Storage::putFileAs('/users', $image, $filename);
            // Save the file path to the user's profile
            $validatedData['profile_pic'] = json_encode($filename);
        }
        $user = User::create($validatedData);
        $data = $this->respondWithToken($user);

        return $this->response('User registered successfully.',$data ,201 );
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // Other methods like login, etc.

    protected function respondWithToken($user)
    {
        $token = JWTAuth::fromUser($user);
        return [
            'name'=>$user->name,
            'email'=>$user->email,
            'id'=>$user->id,
            'delivery_address'=>$user->delivery_address,
            'profile_pic'=>json_decode($user->profile_pic),
            'token'=>$token
        ];
    }
}
