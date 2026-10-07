<?php

return [
    'required' => 'Pole :attribute je povinné.',
    'email' => 'Pole :attribute musí byť platná e-mailová adresa.',
    'numeric' => 'Pole :attribute musí byť číslo.',
    'integer' => 'Pole :attribute musí byť celé číslo.',
    'string' => 'Pole :attribute musí byť text.',
    'confirmed' => 'Potvrdenie poľa :attribute sa nezhoduje.',
    'min' => [
        'numeric' => 'Pole :attribute musí byť najmenej :min.',
        'string' => 'Pole :attribute musí mať najmenej :min znakov.',
    ],
    'max' => [
        'numeric' => 'Pole :attribute nesmie byť väčšie ako :max.',
        'string' => 'Pole :attribute nesmie mať viac ako :max znakov.',
    ],
    'in' => 'Vybraná hodnota poľa :attribute je neplatná.',
];
