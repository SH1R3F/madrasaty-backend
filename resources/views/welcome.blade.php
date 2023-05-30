<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>مدرستي</title>
    <link rel="stylesheet" type="text/css" href="/loader.css" />
    <script type="module" crossorigin src="/assets/index-9bb34dbd.js"></script>
    <link rel="stylesheet" href="/assets/index-63ce5804.css">
</head>

<body>
    <div id="app">
        <div id="loading-bg">
            <div class="loading-logo">
                <!-- SVG Logo -->
                <svg fill="#000000" height="48" width="75" version="1.1" id="Layer_1"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 300.14 300.14" xml:space="preserve">
                    <g>
                        <g>
                            <g>
                                <path
                                    d="M128.14,115.176c0,12.092,9.838,21.93,21.93,21.93s21.93-9.838,21.93-21.93s-9.838-21.93-21.93-21.93
        				S128.14,103.083,128.14,115.176z M159.1,115.176c0,4.979-4.051,9.03-9.03,9.03s-9.03-4.051-9.03-9.03
        				c0-4.979,4.051-9.03,9.03-9.03S159.1,110.196,159.1,115.176z" />
                                <path
                                    d="M293.69,90.379h-87.539l-51.414-53.902c-2.541-2.663-6.795-2.662-9.334,0L93.989,90.379H6.45
        				c-3.563,0-6.45,2.888-6.45,6.45c0,8.219,0,154.422,0,162.381c0,3.562,2.887,6.45,6.45,6.45c7.821,0,279.408,0,287.24,0
        				c3.563,0,6.45-2.888,6.45-6.45c0-8.005,0-154.233,0-162.381C300.14,93.267,297.253,90.379,293.69,90.379z M90.3,252.76H12.9
        				V143.749h77.4V252.76z M90.3,130.85H12.9v-27.571h77.4V130.85z M165.406,252.76h-30.673v-50.868h30.673V252.76z M196.94,252.76
        				h-18.634v-57.318c0-3.562-2.887-6.45-6.45-6.45h-43.573c-3.563,0-6.45,2.888-6.45,6.45v57.318H103.2c0-2.552,0-150.834,0-153.348
        				l46.87-49.138l46.87,49.138C196.94,101.926,196.94,250.208,196.94,252.76z M287.24,252.76h-77.4V143.749h77.4V252.76z
        				 M287.24,130.849h-77.4v-27.571h77.4V130.849z" />
                                <path
                                    d="M229.62,189.615h37.84c3.563,0,6.45-2.888,6.45-6.45s-2.887-6.45-6.45-6.45h-37.84c-3.563,0-6.45,2.888-6.45,6.45
        				S226.057,189.615,229.62,189.615z" />
                                <path
                                    d="M229.62,219.794h37.84c3.563,0,6.45-2.888,6.45-6.45c0-3.562-2.887-6.45-6.45-6.45h-37.84c-3.563,0-6.45,2.888-6.45,6.45
        				C223.17,216.907,226.057,219.794,229.62,219.794z" />
                                <path
                                    d="M32.68,189.615h37.84c3.563,0,6.45-2.888,6.45-6.45s-2.887-6.45-6.45-6.45H32.68c-3.563,0-6.45,2.888-6.45,6.45
        				S29.117,189.615,32.68,189.615z" />
                                <path
                                    d="M32.68,219.794h37.84c3.563,0,6.45-2.888,6.45-6.45c0-3.562-2.887-6.45-6.45-6.45H32.68c-3.563,0-6.45,2.888-6.45,6.45
        				C26.23,216.907,29.117,219.794,32.68,219.794z" />
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
            <div class=" loading">
                <div class="effect-1 effects"></div>
                <div class="effect-2 effects"></div>
                <div class="effect-3 effects"></div>
            </div>
        </div>
    </div>

    <script>
        const loaderColor = localStorage.getItem('vuexy-initial-loader-bg') || '#FFFFFF'
        const primaryColor = localStorage.getItem('vuexy-initial-loader-color') || '#7367F0'

        if (loaderColor)
            document.documentElement.style.setProperty('--initial-loader-bg', loaderColor)

        if (primaryColor)
            document.documentElement.style.setProperty('--initial-loader-color', primaryColor)
    </script>
</body>

</html>
