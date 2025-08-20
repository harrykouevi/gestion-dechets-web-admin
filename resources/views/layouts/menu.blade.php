<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<li class="nav-item">
    <a class="nav-link disabled" href="{{ route('getusers') }}">
        <i class="fas fa-fw  fa-user-tie"></i>
        <span>Utilisateurs</span></a>
</li>
<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMenages"
        aria-expanded="true" aria-controls="collapseMenages">
        <i class="fas fa-fw fa-home"></i>
        <span>Ménages</span>
    </a>
    <div id="collapseMenages" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('menages.index') }}">Liste</a>
        </div>
    </div>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed " href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-recycle"></i>
        <span>Gestion des collectes</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">****:</h6>
            <a class="collapse-item" href="{{ route('types-dechets.index') }}">Type de dechets</a>
            <a class="collapse-item" href="{{ route('agents.index') }}">Agents de collectes</a>

            <h6 class="collapse-header">Déclarations:</h6>
            <a class="collapse-item" href="{{ route('requestcollects.index') }}">Liste</a>
            <a class="collapse-item" href="{{ route('requestcollects.stats', ['report' => true]) }}">Statistics</a>
            <h6 class="collapse-header">Collectes:</h6>
            <a class="collapse-item" href="{{ route('collectes.index') }}">Liste</a>
            <a class="collapse-item" href="{{ route('collectes.stats', ['report' => true]) }}">Statistics</a>

        </div>
    </div>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCourse"
        aria-expanded="true" aria-controls="collapseCourse">
        <i class="fas fa-graduation-cap fa-fw"></i>
        <span>EDU_C</span>
    </a>


    <div id="collapseCourse" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Posts éducatifs:</h6>
            <a class="collapse-item" href="{{ route('posts.index') }}">Les contenus</a>
            <h6 class="collapse-header">Quizs:</h6>
            <a class="collapse-item" href="{{ route('quizzes.index') }}">Les quiz</a>
            <a class="collapse-item" href="{{ route('rewards.index') }}">Les récompenses</a>
            <h6 class="collapse-header">Statistiques:</h6>
            <a class="collapse-item" href="{{ route('posts.index', ['report' => true]) }}">Voir</a>

        </div>
    </div>

</li>
