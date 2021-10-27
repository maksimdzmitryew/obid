                <p class="confidentiality">
                    @if ($id == 'signup')
                        я погоджуюсь з <a href="/info/confidentiality" target="_blank">Правилами та Політикою конфіденційності Provodnik</a>
                    @elseif ($id == 'footer')
                        Використовуючи сайт Provodnik, ви автоматично приймаєте <a href="/info/confidentiality" target="_blank">Правила та Політику конфіденційності Provodnik</a>
                    @endif
                </p>
