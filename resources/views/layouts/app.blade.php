<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>@yield('title')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script type="text/javascript">
        const App = {
            cart: @json($cart),
            lang: @json(__('lang', [], 'ru')),
        }
    </script>
    @routes()
</head>

<body>
    <div id="app">
        <header class="header">
            <div class="container">
                <nav class="navbar navbar-expand-lg bg-body-tertiary">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <button type="button" class="menu-button" data-bs-toggle="offcanvas" data-bs-target="#menu" aria-controls="menu">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="#333" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                                </svg>
                            </button>
                        </div>
                        <div>
                            <a class="navbar-logo" href="/">
                                <div class="Logo" style="background-image: url(/assets/images/logo.png?v=001);">
                                </div>
                            </a>
                        </div>
                        <div>
                            <a href="/profile">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect width="30" height="30" fill="url(#pattern0)" />
                                    <defs>
                                        <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                            <use xlink:href="#image0_106_140" transform="scale(0.01)" />
                                        </pattern>
                                        <image id="image0_106_140" width="100" height="100" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAAAXNSR0IArs4c6QAAEG5JREFUeAHtXQmQHUUZnmxCQCFvejaJwbzu2QVW0SWZ/mefgHixKIoHyiEpq9QCSks8kWh5lRUu8UARFIgnSCmIpQheUUACRFQ8isNbBAqwPDiEiKggScjG+nrmDTM9Pe/NvDcz7+2yW7X15uj+r+6e/rv/oy1rlv6tWOHtuuseq1bYorWX7U611L9o7YVneDdL2Rpuspc091vaEPIQ5tIJdpM+y7i82hb0VyZoR55/VRZ1UNf13wlYgDncXA8RdejZtusf7HD/dNaUNzJB2/MIvnAZTnc4nL5gu7SGjRMbIhEMASmTk4sd13ulI+gSxmlLYeHmHC2ZcIGT0wY0jjU5uXgIJDIYEhy+ejUTtJ4J2pwprH6FXbi+9wBoAm2DkcoAsDa4t3+jSd9lgmYKNwSnLTaXt6C+LbyL8dlxXPo4E/6J+Me1+hQJ72JVhstbGJdbC+MRNNPg3ncagvYdgIjqQem48nlMeBtzC4fLrY0m/YS58lTHlYc2OD3NsqYXFad2ehHq4rPIhPwQE/TTIo3kcPrh6Bg9pzjeIa0BNZRxeWGuEcHpPsbl2aN86qVVqq7Ll0/uBhzMlecwIf+Ro5PMNIT35d1WeE8ZUjHnImuEuf7RTKjvcraayunRaFJttXbKBbnUQmsWQrNDp7GFfLhj43B6ECq4Za1ZWCoJVQNj4zTuCPpFJ+Zsl/6Nbz5GUNX05IW/fHzf3R2XPmEL+k9n2r2fsT38sbxwB1qOcXkEQ0/K0nA4/ZNxOrnB9xkdKKEdkIM2zF1d+RB0WAcwg341vUgt6LK1pxl8FmbTdxgNA62tw/wHns4euvULJslOGpTj0p/wnR50l+kVvyO859uCfpc56gVtcvZs2b3CL7XesrHWU20hf51B7AzmCWsgk3WpbFrgwRF0RuZo4XQz5qCSsRYDZ495ezAhbzM3hveAM0avKAZx+EtjTZSpOXK6M1gvDYCPBp+asLm8x9QYtpA/H216fABk1YJydOUqwQT90sg7l/fAJFALIW0kmJg7jIyNmFPaZefq78qVrSfbrvcDU6MwTnfgU14L76MT+zcYp5uNhLh00ZyYL3JLcnoRE/J8kyxs4f+2+q39ycnFtqDrTAQ0OH3asqwFuXmZOwUXQPU1yYQJ2lSpSpyJ2KWvPkEbo92tFjBBFxgbpemf2S5U6m+gXRi2zDl9v7dd2FLJGzywVmunjDkFZobDSyVQqbeG7RBoU5jcSkU2i4FhhzpD+9pc4t7XmoXmjUJ5/1xWbXvtF87Klmu0gnJ5vWVZI73Cjeo5XL7D8G2cYcJ/VVRo/iIhAYfTy00retuVb04ULHoTGJfSO7dqO6QosPLKj7Ax6TPuH28L+Tl8t23h/Uj941q5C/nHsyZRKT2yR7qZkJ80dOTNu+3uL+8RpGWFlr6EcQn69SDWGlj9gsms3QED8zsYl3dj/8l2V+/ZsxB6rTg5uZhx+QcDXRf0BDKwgae0qhnsfPYEsMdKy4S/MugY8jEDc4nOkv1eboMJtrbVc8gr4zRt+HTNjDannl1YHKbtdDBVGFAfFZhLx9hcPpQt6HwejO36Npf/glm5D5IKV2UuXdTG3/61hbyiECC46rQrR7+cHqzPuATNzv98hDvL+hg+hy28qz08BgNzT112cWzJq44Qww++bOE/K3ejhH5Tyc8Bp5NzA+ir4PQi5spLsxtDbmPcvwaT+qjrTy5btveSNjpcj7pyH/jxqjKiw2fOlZfWtaBlwj/NwM+32nR3/A09ChNObHBIqMsGnrkFAdMwp28uacqnd2Qg9hJlw8ZN8PO4cOT5seKVXS5Z2VpmcJzAfLyqK1JbeJ95nODgG12XmusIeruOO7j3HrBd/0Vdic8oYLv0YuNiTdAOR/hvyahW6mOzGuyf2xkJVDXNj8rm8n91uOrA0gZceoPAdbQMgw8MarDtp+AL+UgZ8DsL1rIwlzD4oCXmEnl/xyWEcuFJVEAPoku6ISvjPTSPJLG0g8GTsUT/J/iLGT0V1QZpGVx0hpExN2a7EjFB39aFAp/Yzmj6fzva9A/Q8cL/1nHpuf1DT0LAOooJuU3H1+Byv2TJ8u+YoMN0vGgkI6bQEpiMz+B0X8chZYRU/KEj6Bs6oZjLikPKV8OkUjtN/+v5avdRSk0J8v4Er5weNZq8Q3uHpurKs/tAn6uq7a529LkDGkmV81bgukT/jQsGNNThWxXGxCTk7HD/ZSlhsaZ/ZpxAXCMmL1Ww5AcqrEybt5hL55WMJgXOqF5zeWSqYMkP4Bqlyxn+xCk0zKVfJQpy2lJlSECbAGOPceWh7fdV/cJ8kOAXncKV51SFrw0Xi9dUfEpT3th+r34RmaoHWCJYJlGoohs4AiQEw+VWa3x6l4rQRWA5P+BJqcmd+9dEBSq8YFxen+BZ0HZ8uiOUKngl9dmQp0YFKrywufxznDhb+H+pEF0CdCrEukl3JQpUdGM36cNxnnFtC/mSCB2CUPQCmOSjAhVe6C7/MBdXiC4B2mD/3pwoUNGNSf2FZTZCp6xs2gipy0dV3+OB5S8irOIL4Ip3ROzZVYxSgV+y0ts7jje8Xh/hDnZGY7YFTlvq2gk1WABvjQir+IIJeXtcMA0u/14xygB8q7WTYWK/KsJtC/pbnDC76f0xelnxBRP+TQncNfVSOPbZIrkWYdy7oWJ2I/D6vlp87lzAdLsBpw1RzYovbEFfizeIum76smK0lnKU0D7TLPDArBq1gp92qpPb1IvQuSuxcoTZsRaqLDhS+MenGqQGY5iKIdQaxBH0trr4NnVEqOLBtrBGWGDirIe0peOtZ+gNguFcrYkVXut0q463LkUGkjXtp6ntIhChE2ZcylfYPvo8Anps7r+xKpS2K4/Tea5z/gBfJoOVsssYv6XcP6kqYZjg2pzepAsIikYVm32I2YA2lcJXYQcw8cy4f5JOA9rCQia21Ash15mAVPZsYmLn1Ko5WL1eUe6nS3mzXKnzi92CSuM4DIJjQq5L0eFOtSzlpZGaQ+gjBhiVPrKFfI1OIO5Du0j/TsqWNWJaACscrn9UpcwZgNuCPqrzCy8aC26W+gsm6CwDjMofISWSgZYdeB539ylKCOoaXZtUR/QvKwqvjPJM0Kd0XhH2YSmHam2EMOF/qQykRWFgxxMBkzqhuA8WUsU97sN9o5RGFeCQt1cfB2iWgske03bEHtGX8YVdHc04e3oK7xDWpHtNjYJnQQ4tOqZTMkv4QTFBx6rcWKnOFm4RNeneOrxNsoSAPFwJHmF2aMePYNkef6k83LMg1fBcObg16a44Telr+RhU1eAz55/LhH+uuubeDamdB71RON1ZxOGuCpYbnH4f50kpFm1ECE3TXj406CBOFQvflFfF6Srj2hH+le1PQ5v/AfwuwM5ygp8gwiogxRQHUqY/VB8Mj8CzkCGlk97Li99vDiOYytDY+mDJsoKUJLHddeW/QF+JgNqc3qszXIc/VkRAlwtMvCrRJZd363R2vVd15LpBTd4m1kwGKibku6OyKnu03uNqXq1HxHS8WLMQpk6o5Zg/dOMWGkc9U/MInRWYRYcvHR9z6RS9IyXSV4Wqb9JDvCaDf0f553gJr3yspfBfl4d+DrI6Fkk5dgiagWaYqASn5nirwXGsDu+PBBFPhJvx6V10x0BoXCnWTdsK9pj3wlTB+Qd9SQBhFfGOH1wbwhJs1z8qV8G+yJmvbIq/sbn/6pRksN+jDyU4IESrx1SN+Qc9SAC7IglNETKHo7sRVkP430uNEu4faCw8/7CwBDAF6PLF7kImIIQh6xVg+82sMP+ikARMYRcOp9dmAsHQSS/paUuVoQGZxMyxF2FIWyL+BrLualaAg4M+SmBunGPyqZ0dZPPW5QrNtishDp/y9IqIYM2ceLpCLKMAEuav3hM7CojURTpBxJAg/tEWdHmUfEbQ5eqkHpfOgwEIZbFaR91yTcHFeFLRaYaDa3IfHMNculZvFEfQB4uR0XtpGKrCY5DOULm6yjgKidMWwIJHjYoWq/HsKZP9HDLOLSHWlAfpDYId19TyPjfE7gVVkhmX1obJ0qo5DCy5X7ddmR1cOqHKpDQq9sa0W92UB3WXSqxEg/s/1hsFzl2xIv1fTkzsrCx7SJWhu7MmhZf0rCz9HYxd8mrQYk1M7Nw/Y49DMDnE9eThz7h/oN4gSmjwHerzD/5Wjut/QF8kpfElbQbG98GBMDgCA/9aYH6O+nrjcnm37cr3l+ETZo95U+aO5r+gJxGa9OZ+UjTBJoE0HcVSLsltONNQ7bW5tBaxgXBdCkPATHmCR9QcJLxVKo7QpbXBPh287NPx6cZGVp6T8iGby4/10zCBeTnZKfpKxIAc54a0R/my2CS7wAgT8g0qM4PeI033KhObfxoSgJUZeKocy5vyIISUIeQiqzESzwOHi2N7MWnrGeUgSyTJTIqm4B08wiMCcWxdwSQwyAtlCB1LzwnKqcE/cenY1DMLkthzcTimwRKpxzlG/MY6CxQAeHkWQaZ72Nuc3lekfmZZHBsHB+WCwsKoWNf1MwEVm8sjBrlOAG7G5ZEGw5HWceS2UP3Pa5cfCcMtLnC4fH0voyyzUYq8gBqZCpOL9TbVA7l/TaGsakUI6KMsDpM0rcOSo8bbOPDDW/LyqI6g63A2oC3oNwjDzgtvUOWQe1edcKB3pPY9p/uKfr5r58Xh9DrdCzLqWcjuw/3T60hmUx7j04ugAmeq01j9d9qtLY+Q4pBUnsOM47YxKlTsQ3GwQ1FDRQgEnizanKJU2pnSJuuSuF2A/aFoJLSHdPQLe3EvZ9iWRF1ZYHD6gSH9YZvvMA2iaV1UFgX54CjPwkj4sUWQUpHlcfmgzJ5S8H7M+iw7wn/rwDlR3uiGBlEHxg+cumoIMKaUCpz0rqsGYwGopszNGMZwkEh44xWAOcxFwZMh+4SaWxoi5p87KCaWctnUU1S0v6tByif/tDkxh1jTi8IsPhmmAXkbTAiDaocEXrhwmnLFtxtGrT1m8SHxKjA2W8vawZryqnCzMyGXAd+oYPz17UYw/G6HbWC2+N9CmKDVcemLenK3BG84nHiYtUjs6qY8V2KTfnBCAZ0yTOEBek9W4Q+uPNWURL/dGCGP2AUe/j8EpOi5qNqMRL84ZIzTyVWaT4tKSu3BdWmIkP5NSMpcFP6gy2O39122kI9EjRAbKdEzLrcimTDysw9oN3QkyA3vX5a1vmjTqnhxae2sdq/FSW7hIfEZ2klsMYlNSS4vhJ5fpmEq1TMREuD6B+OgTD1XWFv42u+McjlCHPlc+QtTeCQzkJpGTPgsTC62CRuSOJgR1sseR9CC8Ci7wwEr8OGSD2sCN+1RBc9cuha28bnSDik+VHwEpw0dNZeshuL0KBIIBIn71aHA64MGU4awdWHjrceBwYi2VSmYenN82M44bXhCxccgThybdaY4wdy9N6vhenwe0rJ+0DHsqV5c64Px6V3gpRjOHcnY7R4FW6RB1USNEev6R3d1fK5VMEOADOfqKts2jsNWZ7Z3OEOq58YCTP8mdfI1l0fOn+VboOFVFh8hD0EcfeAB6G1kyjslT0PJx4Ky3kbUtQW9B47X86OgQAMUKYrVNDbzkKwGGhz+ca18hGt0pC5Cc56y/we2RKXrSNBPAwAAAABJRU5ErkJggg==" />
                                    </defs>
                                </svg>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <main>
            @yield('content')
            @if(false)
            <footer class="footer">
                <div class="container">
                    <div class="copyright">
                        <div>&copy; проект команды «Fairy Tail» {{date('Y')}}</div>
                        <div>специально для <a href="https://ityakutia.com/hacktheice5" target="_blank" rel="noopener noreferrer">HACK-the-ICE 5.0 «OldSchool»</a></div>
                    </div>
                </div>
            </footer>
            @endif
        </main>
        <aside>
            <div class="modal fade" id="cityModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Населенный пункт</h1>
                            @if(session()->has('city.uuid'))
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            @endif
                        </div>
                        <div class="modal-body">
                            <div>
                                <div>
                                    <div class="text-center">
                                        @foreach($districts as $district=>$cities)
                                        <div class="mb-4">
                                            <div class="fw-bold">{{$district}}</div>
                                            @foreach($cities as $city)
                                            <div><a href="{{route('set_city', $city)}}">{{$city->name}}</a></div>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.menu')
        </aside>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="arrow-right-circle" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
            </symbol>
        </svg>
    </div>

    @unless(session()->has('city.uuid'))
    <script type="module">
        $("#citySelectBtn").trigger('click');
    </script>
    @endunless
</body>

</html>