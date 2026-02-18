<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .header-bg {
            background-color: #005a9c;
        }

        .section-title {
            color: #005a9c;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 1.25rem;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="max-w-4xl mx-auto bg-white shadow-lg mt-10 mb-10">
        <div class="header-bg text-white p-8 flex flex-col md:flex-row items-center md:items-start">
            <div class="w-32 h-50 bg-gray-300 border-4 border-white overflow-hidden flex-shrink-0 mb-4 md:mb-0 md:mr-8">
                <img src={{ $path }} alt="Profile" class="w-full h-full object-cover">
            </div>

            <div class="flex-grow w-full">
                <h1 class="text-4xl font-bold">{{ $name }}</h1>
                <p class="text-xl font-light mb-4">{{ $position }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                    <p><span class="font-bold">Phone:</span> {{ $contacts['phone'] }}</p>
                    <p><span class="font-bold">Nationality:</span> {{ $nationality }}</p>
                    <p><span class="font-bold">Email:</span> {{ $contacts['email'] }}</p>
                    <p>
                        <span class="font-bold">Age:</span> {{ $age }}
                        @if($age == 21)(Dalawampu't isa)
                        @elseif($age >= 22 && $age <= 23)(Duapulo ket {{ $age == 22 ? 'dua' : 'tallo' }})
                            @elseif($age> 24)(duamplo tan apat)
                            @endif
                    </p>
                    <p><span class="font-bold">LinkedIn:</span> {{ $contacts['linkedin'] }}</p>
                    <p><span class="font-bold">Gender:</span> {{ $gender }}</p>
                    <p><span class="font-bold">GitHub:</span> {{ $contacts['github'] }}</p>
                    <p><span class="font-bold">Address:</span> {{ $contacts['address'] }}</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <p class="mb-8 text-gray-700">{{ $bio }}</p>
            <div class="mb-8">
                <h2 class="section-title">Education</h2>
                @foreach($education as $edu)
                <div class="mb-4">
                    <div class="font-bold text-gray-500">{{ $edu['year'] }}</div>
                    <h5 class="font-medium">{{ $edu['school'] }}</h5>
                    <p class="text-sm">{{ $edu['details'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="mb-8">
                <h2 class="section-title">Experience</h2>
                <div class="w-1/4 font-bold">{{ $experience }}</div>
            </div>

            <div>
                <h2 class="section-title">Skills</h2>
                <ul class="list-disc list-inside">
                    @foreach($skills as $skill)
                    <li>{{ $skill }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</body>

</html>