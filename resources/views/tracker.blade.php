<!DOCTYPE html>
<html>
<head>
    <title>Enhanced Contract Tracker</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            padding: 20px;
            line-height: 1.6;
        }

        .progress-bar {
            height: 8px;
            background-color: #4a90e2;
            transition: width 0.5s ease;
            border-radius: 4px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: linear-gradient(
                -45deg,
                rgba(255, 255, 255, 0.2) 25%,
                transparent 25%,
                transparent 50%,
                rgba(255, 255, 255, 0.2) 50%,
                rgba(255, 255, 255, 0.2) 75%,
                transparent 75%,
                transparent
            );
            background-size: 20px 20px;
            animation: move 1s linear infinite;
        }

        @keyframes move {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 20px 20px;
            }
        }

        .phase-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            margin: 0 10px;
        }

        .phase-indicator::before {
            content: '';
            width: 16px;
            height: 16px;
            background-color: #d1d5db;
            border-radius: 50%;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #d1d5db;
        }

        .phase-indicator.active::before {
            background-color: #4a90e2;
            box-shadow: 0 0 0 2px #4a90e2;
        }

        .phase-indicator span {
            font-size: 0.85rem;
            text-align: center;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .phase-indicator.active span {
            color: #4a90e2;
            font-weight: 600;
        }

        .btn {
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn:hover {
            background-color: #3a7bc8;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn.disabled {
            background-color: #d1d5db;
            color: #9ca3af;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        input, textarea {
            width: 100%;
            display: block;
            margin-bottom: 16px;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f9fafb;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4b5563;
        }

        h2 {
            margin-bottom: 24px;
            font-size: 1.5rem;
            color: #1f2937;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 8px;
        }

        .form-container {
            background: #fff;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .flex {
            display: flex;
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .mb-4 {
            margin-bottom: 16px;
        }

        .mt-4 {
            margin-top: 16px;
        }

        @media (max-width: 640px) {
            .form-container {
                padding: 24px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 0.85rem;
            }

            h2 {
                font-size: 1.25rem;
            }
        }
        .activity-form {
            margin-top: 20px;
        }

        .activity-form textarea {
            height: 150px;
        }

        .pdf-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .pdf-actions .btn {
            flex: 1;
            margin: 0 10px;
        }

        #pdfPreview {
            width: 100%;
            height: 300px;
            border: 1px solid #d1d5db;
            margin-top: 20px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="form-container">
        <h2 class="mb-4">Enhanced Contract Tracker</h2>
        <div class="flex justify-between mb-4">
            @foreach ($phases as $index => $phase)
                <div class="phase-indicator {{ $index <= $currentPhase ? 'active' : '' }}">
                    <span>{{ $phase }}</span>
                </div>
            @endforeach
        </div>

        <div class="w-full mb-4">
            @php
                $progressPercentage = is_numeric($currentPhase) && is_numeric(count($phases)) 
                    ? min(100, max(0, ($currentPhase / (count($phases) - 1)) * 100)) 
                    : 0;
            @endphp
            <div 
                class="progress-bar" 
                style="width: <?php echo $progressPercentage; ?>%;"
                role="progressbar"
                aria-valuenow="{{ $progressPercentage }}"
                aria-valuemin="0"
                aria-valuemax="100"
            ></div>
        </div>

        <form method="POST" action="{{ route('contract-tracker.submit') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="currentPhase" value="{{ $currentPhase }}">

            @switch($currentPhase)
                @case(0)
                    <h2>Contracting Phase</h2>
                    <label for="contracting">Upload Contracting Form</label>
                    <input id="contracting" type="file" name="contracting" accept=".pdf,.doc,.docx">
                    @break
                @case(1)
                    <h2>Needs Assessment</h2>
                    <label for="userGmail">Your Gmail</label>
                    <input id="userGmail" type="email" name="userGmail" value="{{ old('userGmail') }}" placeholder="Enter your Gmail address" required>

                    <label for="clientGmail">Client's Gmail</label>
                    <input id="clientGmail" type="email" name="clientGmail" value="{{ old('clientGmail') }}" placeholder="Enter client's Gmail address" required>

                    <label for="needsAssessment">Needs Assessment Form</label>
                    <textarea id="needsAssessment" name="needsAssessment" placeholder="Enter needs assessment details" rows="5" required>{{ old('needsAssessment') }}</textarea>
                    @break
                @case(2)
                    <h2>Activity Design</h2>
                    <div class="activity-form">
                        <label for="activityTitle">Activity Title</label>
                        <input id="activityTitle" type="text" name="activityTitle" value="{{ old('activityTitle') }}" placeholder="Enter activity title" required>

                        <label for="activityDescription">Activity Description</label>
                        <textarea id="activityDescription" name="activityDescription" placeholder="Enter activity description" rows="5" required>{{ old('activityDescription') }}</textarea>

                        <label for="activityDuration">Activity Duration (in minutes)</label>
                        <input id="activityDuration" type="number" name="activityDuration" value="{{ old('activityDuration') }}" placeholder="Enter activity duration" required>

                        <label for="activityMaterials">Required Materials</label>
                        <textarea id="activityMaterials" name="activityMaterials" placeholder="Enter required materials" rows="3" required>{{ old('activityMaterials') }}</textarea>
                    </div>

                    <div class="pdf-actions">
                        <button type="button" class="btn" onclick="generatePDF()">Download as PDF</button>
                        <label for="uploadPDF" class="btn">
                            Upload PDF to Client
                            <input id="uploadPDF" type="file" name="uploadPDF" accept=".pdf" style="display: none;" onchange="previewPDF(this)">
                        </label>
                    </div>

                    <iframe id="pdfPreview" style="display: none;"></iframe>
                    @break
            @endswitch

            <div class="flex justify-between mt-4">
                <button type="submit" form="previousForm" class="btn {{ $currentPhase === 0 ? 'disabled' : '' }}" {{ $currentPhase === 0 ? 'disabled' : '' }}>
                    Previous
                </button>

                @if ($currentPhase < count($phases) - 1)
                    <button type="submit" class="btn">Next</button>
                @else
                    <button type="submit" class="btn">Submit</button>
                @endif
            </div>
        </form>

        <form id="previousForm" method="POST" action="{{ route('contract-tracker.previous') }}">
            @csrf
        </form>
    </div>

    <script>
        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const title = document.getElementById('activityTitle').value;
            const description = document.getElementById('activityDescription').value;
            const duration = document.getElementById('activityDuration').value;
            const materials = document.getElementById('activityMaterials').value;

            doc.setFontSize(18);
            doc.text('Activity Design', 10, 10);

            doc.setFontSize(14);
            doc.text(`Title: ${title}`, 10, 20);

            doc.setFontSize(12);
            doc.text(`Description: ${description}`, 10, 30);
            doc.text(`Duration: ${duration} minutes`, 10, 50);
            doc.text(`Materials: ${materials}`, 10, 60);

            doc.save('activity_design.pdf');
        }

        function previewPDF(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const pdfPreview = document.getElementById('pdfPreview');
                    pdfPreview.src = e.target.result;
                    pdfPreview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
    </script>
</body>
</html>
