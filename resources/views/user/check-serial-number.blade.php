<!DOCTYPE html>
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,300&display=swap" rel="stylesheet">
  <!-- sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.16/dist/sweetalert2.all.min.js"></script>
  <!-- select2 js -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
      integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://kit.fontawesome.com/b121968cc9.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/table/base-table.css') }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Voice Input Form (Bengali)</title>
  <style>
    .form-container {
      max-width: 500px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      margin-bottom: 5px;
    }
    .form-group input {
      width: 100%;
      padding: 8px;
      border-radius: 3px;
      border: 1px solid #ccc;
    }
    .submit-btn {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: #fff;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="p-4">
    <a href="{{route('find_doctor')}}" class="btn btn-success">Go To Home</a>
  </div>

  <div class="col-md-12">
    <h3 class="text-center mt-5">সিরিয়াল নাম্বার দেখুন</h3>
    <div class="form-container mt-4">
      <form class="myForm" id="voiceForm" method="GET" action="{{ route('check.serial.number') }}">
        <div class="form-group">
          <label for="name">আপনার মোবাইল নাম্বারটা বলুন</label>
          <input class="myInput" type="text" id="name" name="mobile_number" placeholder="আপনার মোবাইল নাম্বারটা বলুন" required>
        </div>
        <button class="d-none" type="submit" class="submit-btn mt-5"></button>
      </form>
      @isset($serialNumbers)
      @forelse($serialNumbers as $serialNumber)
      <div>
        <p>ডাক্তারের নাম:{{$serialNumber->doctor->name}}</p>
        <p>সিরিয়াল নাম্বার:{{$serialNumber->serial_no}}</p>
      </div>
      @empty
      {{-- <h1>xdhgdhdgd</h1> --}}
      @endforelse
      @endisset
    </div>
  </div>

  <script>
    const nameInput = document.getElementById('name');
    const voiceForm = document.getElementById('voiceForm');

    nameInput.addEventListener('click', startSpeechRecognition);

    function convertEnglishToBengaliNumber(number) {
      const englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
      const bengaliNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

      let convertedNumber = '';
      for (let i = 0; i < number.length; i++) {
        const char = number[i];
        const index = englishNumbers.indexOf(char);
        if (index !== -1) {
          convertedNumber += bengaliNumbers[index];
        } else {
          convertedNumber += char;
        }
      }

      return convertedNumber;
    }

    function startSpeechRecognition(event) {
      const inputField = event.target;
      const recognition = new webkitSpeechRecognition() || new SpeechRecognition();
      recognition.lang = 'bn-BD'; // Set the language to Bengali

      recognition.onresult = (event) => {
        const result = event.results[event.results.length - 1][0].transcript;
        const convertedResult = convertEnglishToBengaliNumber(result);
        inputField.value = convertedResult;
        voiceForm.submit(); // Submit the form after setting the voice input value
      };

      recognition.start();
    }
  </script>

  <script>
    $(document).ready(function() {
      $('.myInput').on('input', function() {
        $('.myForm').submit();
      });
    });
  </script>
</body>
</html>
