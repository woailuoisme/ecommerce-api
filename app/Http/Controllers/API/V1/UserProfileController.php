<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserProfileController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function avatar(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'photo' => 'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
//            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000' // max 10000kb
        ]);
        /** @var User $user */
        $user = Auth::guard('api')->user();
        if ($request->hasFile('avatar')) {
            $uploadedFile = $request->file('avatar');
            $file_path = $uploadedFile->store('avatars', ['disk' => 'public']);
            $width = 48;
            $height = 48;
            $thumbImage = Image::make($uploadedFile)->resize($width, $height)->encode('jpeg');
            $thumb_path = "avatars/thumbs/thumbnail_{$width}_{$height}_{$uploadedFile->hashName()}.jpeg";
            Storage::disk('public')->put($thumb_path, $thumbImage->__toString());

            $fileInfo = [
                'original_path'  => $file_path,
                'thumbnail_path' => $thumb_path,
                'mime_type'      => $uploadedFile->getMimeType(),
                'size'           => $uploadedFile->getSize(),
            ];
            if ($user->avatar && $path = $user->avatar->original_path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $user->avatar()->update($fileInfo);
            } else {
                $user->avatar()->create($fileInfo);
            }
        }

        return $this->sendResponse(new UserResource($user->fresh('avatar')), 'user avatar upload successfully');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([

        ]);
        /** @var User $user */
        $user = Auth::guard('api')->user();
        $profile = $user->profile()->create($validateData);

        return $this->sendData($profile);
    }

    public function udpate(Request $request)
    {
        $validateData = $request->validate([

        ]);
        /** @var User $user */
        $user = Auth::guard('api')->user();
        $profile = $user->profile()->update($validateData);

        return $this->sendData($profile);
    }

}
