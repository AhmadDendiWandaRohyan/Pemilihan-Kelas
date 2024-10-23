<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->role == Role::ADMIN->status();
    }

    public function attributes(): array
    {
        return [            
            'user_id' => __('model.grade.nama_siswa'),
            'mtk' => __('model.grade.nilai_mtk'),
            'fisika' => __('model.grade.nilai_fisika'),
            'kimia' => __('model.grade.nilai_kimia'),
            'biologi' => __('model.grade.nilai_biologi'),
            'sosiologi' => __('model.grade.nilai_sosiologi'),
            'ekonomi' => __('model.grade.nilai_ekonomi'),
            'sejarah' => __('model.grade.nilai_sejarah'),
            'geografi' => __('model.grade.nilai_geografi'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable'],
            'mtk' => ['nullable'],
            'fisika' =>['nullable'],
            'kimia' => ['nullable'],
            'biologi' => ['nullable'],
            'sosiologi' =>['nullable'],
            'ekonomi' => ['nullable'],
            'sejarah' =>['nullable'],
            'geografi' => ['nullable'],
        ];
    }
}