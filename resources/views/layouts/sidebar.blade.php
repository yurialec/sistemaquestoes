<aside class="w-72 shrink-0"> {{-- largura fixa, participa do fluxo (sem fixed) --}}
    <div class="sticky top-16 h-[calc(100vh-4rem)] bg-white border-r">
        <nav class="py-3">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="block px-4 py-2 rounded
                              {{ request()->routeIs('dashboard') ? 'bg-indigo-200 text-gray-900 font-medium' : 'text-gray-700 hover:bg-indigo-200' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('questao.responder') }}"
                        class="block px-4 py-2 rounded
                              {{ request()->routeIs('profile.*') ? 'bg-indigo-200 text-gray-900 font-medium' : 'text-gray-700 hover:bg-indigo-200' }}">
                        Responde Questões
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 rounded
                              {{ request()->routeIs('profile.*') ? 'bg-indigo-200 text-gray-900 font-medium' : 'text-gray-700 hover:bg-indigo-200' }}">
                        Perfil
                    </a>
                </li>
                <li>
                    <a href="{{ route('banca.index') }}"
                        class="block px-4 py-2 rounded
                              {{ request()->routeIs('bancas.*') ? 'bg-indigo-200 text-gray-900 font-medium' : 'text-gray-700 hover:bg-indigo-200' }}">
                        Bancas
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>