<?php

namespace Tests\Datasets\UserDataset;


dataset('get_user', function () {
    return [
        [
            collect([
                "id" => "018e5717-6678-7330-b055-0b961ba00f17",
                "name" => "Jacinto Goyette MD",
                "email" => "alejandra.greenfelder@hotmail.com",
                "role" => "admin",
                "banned_at" => null,
                "telephone" => "1-484-529-6942",
                "avatar" => null,
                "email_verified_at" => null,
                "created_at" => null,
                "updated_at" => "2024-03-20T13:10:55.000000Z"
            ]),
            [
                "id" => "018e5717-6678-7330-b055-0b961ba00f17",
                "name" => "Jacinto Goyette MD",
                "email" => "alejandra.greenfelder@hotmail.com",
                "role" => "admin",
                "banned_at" => null,
                "telephone" => "1-484-529-6942",
                "avatar" => null,
                "email_verified_at" => null,
                "created_at" => null,
                "updated_at" => "2024-03-20T13:10:55.000000Z"
            ]
        ]
    ];
});

