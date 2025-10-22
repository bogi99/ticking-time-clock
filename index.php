<?php
// Handle HTMX time requests
if (isset($_GET['action']) && $_GET['action'] === 'time') {
    $currentTime = date('H:i:s');
    $currentDate = date('Y-m-d');
    echo '<div class="text-6xl font-mono text-green-400 mb-2">' . $currentTime . '</div>';
    echo '<div class="text-sm text-gray-400">' . $currentDate . '</div>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/htmx.org@1.9.12"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
    <script>
        let audioEnabled = false;
        document.addEventListener('htmx:afterSwap', () => {
            if (audioEnabled) document.getElementById('tick')?.play();
        });

        function enableAudio() {
            audioEnabled = true;
            const audio = document.getElementById('tick');
            audio.volume = document.getElementById('volume').value / 100;
            audio.play();
            document.getElementById('enable-btn').style.display = 'none';
            document.getElementById('volume-control').style.display = 'block';
        }

        function updateVolume() {
            const audio = document.getElementById('tick');
            const volume = document.getElementById('volume').value / 100;
            audio.volume = volume;
            document.getElementById('volume-display').textContent = document.getElementById('volume').value + '%';
        }
    </script>
    <title>Clock</title>
</head>

<body class="bg-gray-800 text-white p-8">
    <audio id="tick" preload="auto">
        <source src="data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmMdBSiR2+3SeSUFLXfI8N2PQgITVL3rw31ZFAhNn9HFfldEBylxv/LNeCkGK3bE7t6GNAkXZL3qtUoSCFCn4/C2YxwHOJHX8sx5LAUkdMTp3J1EBBla5/DHgiUJHWq+6txoVwNT/f8AAA8UgG3+0HYuAxuFuLCOlAIA7v//c/7V/QAA/v8IAMLp1VoMJABCqLqtfgIA7v//c/7V/QAA/v8IAMLp1VoMJAAA" type="audio/wav">
    </audio>
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">This is Ticking Clock</h1>
        <hr class="border-orange-600 mb-4">

        <!-- Live Time Display -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4 text-orange-400">Live Time Display</h2>
            <button id="enable-btn" onclick="enableAudio()" class="mb-4 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                🔊 Enable Tick Sound
            </button>
            <div id="volume-control" style="display: none;" class="mb-4 p-4 bg-gray-700 rounded-lg">
                <label class="block text-sm text-gray-300 mb-2">Volume: <span id="volume-display">50%</span></label>
                <input type="range" id="volume" min="0" max="100" value="50" oninput="updateVolume()"
                    class="w-full h-2 bg-gray-600 rounded-lg appearance-none cursor-pointer">
            </div>
            <div
                hx-get="<?php echo $_SERVER['PHP_SELF']; ?>?action=time"
                hx-trigger="load, every 1s"
                hx-swap="innerHTML"
                class="bg-gray-700 rounded-lg p-6 text-center">
                <div class="text-6xl font-mono text-green-400">Loading...</div>
            </div>
        </div>

    </div>
</body>

</html>