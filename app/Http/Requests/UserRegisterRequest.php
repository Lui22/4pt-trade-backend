<?php /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "login" => Rule::unique(User::class),
            "email" => Rule::unique(User::class),
            "INN" => Rule::unique(User::class),
            "OGRN" => Rule::unique(User::class),
        ];
    }
}
