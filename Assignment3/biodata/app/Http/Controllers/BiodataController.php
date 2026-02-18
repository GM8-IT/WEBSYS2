<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BiodataController extends Controller
{
    public function index()
    {
        $name = "Gian L. Malasan";
        $position = "Junior Developer";
        $age = 21;
        $gender = "Male";
        $nationality = "Filipino";
        $bio = "Driven software engineer eager to leverage coding skills to improve quality and help the company grow.";
        $path = "images/pfp.jpg";

        $contacts = [
            'phone' => '09761842173',
            'email' => '23ur0627@psu.edu.ph',
            'address' => 'Sta. Barbara, Pangasinan',
            'linkedin' => 'linkedin.com/in/gian-malasan',
            'github' => 'github.com/GMT-8',

        ];

        $education = [
            'tertiary' => [
                'year' => 'Tertiary: 2023-Present',
                'degree' => 'Bachelor of Science in Information Technology',
                'school' => 'Pangasinan State University - Urdaneta Campus',
                'details' => 'Major in Web & Mobile Technologies'
            ],
            'secondary' => [
                'year' => 'Secondary: 2017-2023',
                'school' => 'Daniel Maramba National High School',
                'details' => '',
            ],
            'primary' => [
                'year' => 'Primary: 2011-2017',
                'school' => 'Mabini Elementary School',
                'details' => '',
            ]
        ];

        $experience = "N/A";

        $skills = ['Flutter', 'Dart', 'Java', 'PHP', 'Laravel', 'HTML/CSS', 'MySQL'];

        return view('biodata', compact(
            'name',
            'position',
            'age',
            'nationality',
            'gender',
            'contacts',
            'education',
            'experience',
            'skills',
            'bio',
            'path'
        ));
    }
}