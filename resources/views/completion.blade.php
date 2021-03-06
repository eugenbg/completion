<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Browser speech recognition</title>

    <style>
        * {
            box-sizing: border-box;
        }
        html,
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Helvetica, Arial, sans-serif;
            color: #0d122b;
            display: flex;
            flex-direction: column;
            padding-left: 1em;
            padding-right: 1em;
        }
        h1 {
            text-align: center;
            font-weight: 100;
        }
        header {
            border-bottom: 1px solid #0d122b;
            margin-bottom: 2em;
        }
        main {
            flex-grow: 2;
            justify-content: space-around;
            align-items: center;
            background-color: #fff;
            border-radius: 12px;
            margin-bottom: 2em;
            padding-top: 4em;
            text-align: center;
        }
        @keyframes bg-pulse {
            0% {
                background-color: #fff;
            }

            50% {
                background-color: #c7ecee;
            }

            100% {
                backgrouond-color: #fff;
            }
        }
        main.speaking {
            animation: bg-pulse 1.5s alternate ease-in-out infinite;
        }
        #result {
            color: #666;
            font-style: italic;
            text-align: center;
        }
        #result .final {
            color: #0d122b;
            font-style: normal;
        }
        button {
            font-size: 18px;
            font-weight: 200;
            padding: 1em;
            width: 200px;
            background: transparent;
            border: 4px solid #f22f46;
            border-radius: 4px;
            transition: all 0.4s ease 0s;
            cursor: pointer;
            color: #f22f46;
            margin-bottom: 4em;
        }
        button:hover,
        button:focus {
            background: #f22f46;
            color: #fff;
        }

        a {
            color: #0d122b;
        }
        .error {
            color: #f22f46;
            text-align: center;
        }
        footer {
            border-top: 1px solid #0d122b;
            text-align: center;
        }
    </style>

</head>
<body>
<header>
    <h1>Email Generator</h1>
</header>
<script>
  window.addEventListener("DOMContentLoaded", () => {
    const button = document.getElementById("button");
    const textarea = document.getElementById("textarea");
    const main = document.getElementsByTagName("main")[0];
    let listening = false;
    const SpeechRecognition =
      window.SpeechRecognition || window.webkitSpeechRecognition;
    if (typeof SpeechRecognition !== "undefined") {
      const recognition = new SpeechRecognition();

      const stop = () => {
        main.classList.remove("speaking");
        recognition.stop();
        button.textContent = "Start listening";
      };

      const start = () => {
        main.classList.add("speaking");
        recognition.start();
        button.textContent = "Stop listening";
      };

      const onResult = event => {
        textarea.value = "";
        for (const res of event.results) {
          textarea.value += res[0].transcript;
        }
      };
      recognition.continuous = true;
      recognition.interimResults = true;
      recognition.addEventListener("result", onResult);
      button.addEventListener("click", event => {
        listening ? stop() : start();
        listening = !listening;
      });
    } else {
      button.remove();
      const message = document.getElementById("message");
      message.removeAttribute("hidden");
      message.setAttribute("aria-hidden", "false");
    }
  });
</script>

<main>
    <form method="POST" action="/">
        <h2>Provide a few words and click "generate email"</h2>
        @csrf

        <textarea rows="5" cols="50" name="text" id="textarea" style="border: 3px solid red"></textarea>
        <div>
            <button type="submit">Generate Email</button>
            <button id="button" type="button">Start listening</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        </div>
        <div style="padding: 1em">
            {!! $text !!}
        </div>
    </form>

    <div id="result"></div>
    <p id="message" hidden aria-hidden="true">
        Your browser doesn't support Speech Recognition. Sorry.
    </p>
</main>


</body>
</html>
