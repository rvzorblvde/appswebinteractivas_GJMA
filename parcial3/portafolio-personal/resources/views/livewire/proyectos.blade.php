<div>
    <h1 class="text-3xl font-bold mb-8 border-b-2 border-slate-700 pb-2 flex items-center gap-3 text-slate-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
        </svg>
        Proyectos Destacados
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-slate-900 p-6 rounded-lg shadow-md border border-slate-800 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-semibold mb-1 text-slate-200">Expediente Clínico Farmacéutico</h2>
                <span class="inline-block bg-cyan-950 text-cyan-300 border border-cyan-800 text-xs px-2.5 py-1 rounded-md mb-3 font-medium">PHP / PostgreSQL / Tailwind CSS</span>
                <p class="text-slate-300 mb-4 leading-relaxed">
                    Proyecto para la Unifarmacia de la UASLP, usando funciones CRUD y Modelo Vista Controlador, desarrollado a lo largo de 3 semestres para las materias de Proyectos Computacionales.
                </p>
            </div>
            <!-- Sustituye la ruta de la imagen con la tuya -->
            <img src="{{ asset('img/unifarmacia-ss.png') }}" alt="Expediente Clínico Farmacéutico" class="w-full h-48 object-cover rounded border border-slate-700">
        </div>

        <div class="bg-slate-900 p-6 rounded-lg shadow-md border border-slate-800 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-semibold mb-1 text-slate-200">Kárdex Académico</h2>
                <span class="inline-block bg-emerald-950 text-emerald-300 border border-emerald-800 text-xs px-2.5 py-1 rounded-md mb-3 font-medium">HTML / CSS / JS / PHP / MySQL</span>
                <p class="text-slate-300 mb-4 leading-relaxed">
                    Sistema de Kárdex Académico realizado para la materia de Fundamentos de Desarrollo Web, utilizando HTML, CSS, JavaScript, PHP y una base de datos en MySQL.
                </p>
            </div>
            <!-- Sustituye la ruta de la imagen con la tuya -->
            <img src="{{ asset('img/kardex-ss.png') }}" alt="Kárdex Académico" class="w-full h-48 object-cover rounded border border-slate-700">
        </div>

        <div class="bg-slate-900 p-6 rounded-lg shadow-md border border-slate-800 flex flex-col justify-between">
            <div>
                <h2 class="text-xl font-semibold mb-1 text-slate-200">Apuntes de Aprendizaje Automático</h2>
                <span class="inline-block bg-emerald-950 text-emerald-300 border border-emerald-800 text-xs px-2.5 py-1 rounded-md mb-3 font-medium">Python</span>
                <p class="text-slate-300 mb-4 leading-relaxed">
                    Repositorio con apuntes y código para la materia de Aprendizaje Automático (Machine Learning).
                </p>
            </div>
            <!-- Sustituye la ruta de la imagen con la tuya -->
            <img src="{{ asset('img/machine-learning-ss.png') }}" alt="Kárdex Académico" class="w-full h-48 object-cover rounded border border-slate-700">
        </div>
    </div>
</div>
