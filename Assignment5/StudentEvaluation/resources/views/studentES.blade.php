<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Evaluation System</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0d47a1, #1976d2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: #ffffff;
            width: 420px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
            border-top: 8px solid #fbc02d;
        }

        h2 {
            text-align: center;
            color: #0d47a1;
            margin-bottom: 20px;
        }

        p {
            margin: 12px 0;
            font-size: 15px;
            color: #333;
        }

        .highlight {
            font-weight: bold;
            color: #12d53f;
            font-size: 18px;
        }

        .passed {
            color: #12d53f;
            font-weight: bold;
        }

        .failed {
            color: #c62828;
            font-weight: bold;
        }

        .award {
            background-color: #fff9c4;
            padding: 8px;
            border-radius: 6px;
            font-weight: bold;
            color: #0d47a1;
            display: inline-block;
            margin-top: 5px;
        }

        hr {
            margin: 15px 0;
            border: 0;
            height: 1px;
            background: #ddd;
        }
    </style>
</head>
<body>

    @php 
        $average = ($prelim + $midterm + $final) / 3;
    @endphp

    <div class="card">
        <h2>Student Evaluation</h2>

        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Average:</strong> 
            <span class="highlight">{{ number_format($average, 2) }}</span>
        </p>

        <hr>

        <p><strong>Letter Grade:</strong>
            @if($average >= 90)
                A
            @elseif($average >= 80)
                B
            @elseif($average >= 70)
                C
            @elseif($average >= 60)
                D
            @else
                F
            @endif
        </p>

        <p><strong>Remarks:</strong>
            @if($average >= 75)
                <span class="passed">Passed</span>
            @else
                <span class="failed">Failed</span>
            @endif
        </p>

        <p><strong>Award:</strong><br>
            @if($average >= 98)
                <span class="award">🏆 With Highest Honors</span>
            @elseif($average >= 95)
                <span class="award">🥇 With High Honors</span>
            @elseif($average >= 90)
                <span class="award">🎖 With Honors</span>
            @else
                No Award
            @endif
        </p>
    </div>

</body>
</html>
