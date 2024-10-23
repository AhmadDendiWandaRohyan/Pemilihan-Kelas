<?php

namespace App\Imports;

use App\Enums\Config as ConfigEnum;
use App\Models\Config;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Debug output to check the data
        \Log::info('Importing row:', $row);

        // Ensure all required fields are present and not null
        if (!isset($row['nisn']) || !isset($row['email'])) {
            \Log::error('Missing required fields in row:', $row);
            return null; // Skip this row or handle the error appropriately
        }
        // $defaultPassword = Hash::make(Config::getValueByCode(ConfigEnum::DEFAULT_PASSWORD));
        $defaultPassword = Hash::make(Config::getValueByCode(ConfigEnum::DEFAULT_PASSWORD));

        return new User([
            'nisn'     => $row['nisn'],
            'email'    => $row['email'],
            'password' => $defaultPassword,
        ]);
    }
}