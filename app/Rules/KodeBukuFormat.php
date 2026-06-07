<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class KodeBukuFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(
        string $attribute, 
        mixed $value, 
        Closure $fail
    ): void {

       // Cek apakah value tidak sesuai dengan format yang diminta
        if (!preg_match('/^BK-[A-Z]{2,4}-\d{3}$/', $value)) {
            // Jika gagal, panggil $fail dan berikan pesan error kustomnya
            $fail(
            'Format kode buku harus: BK-XXX-000 (contoh: BK-PROG-001)'
            ); 
        }
    }
}