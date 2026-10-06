@extends('layouts.dashboard')
@section('title', 'Tableau de bord — ' . site_name())
@section('page_title', 'Gestion du site')

@section('content')
@php
  $user = Auth::user();
  $isSuper = $user->hasRole('super-admin');
  $tools = [
    ['route' => 'admin.site-contacts.edit',   'perm' => 'manage-site-contacts', 'icon' => 'fa-map-marker-alt',   'title' => 'Coordonnées',          'desc' => 'Nom, logo, adresse, e-mail, téléphone et WhatsApp affichés sur le site.'],
    ['route' => 'admin.social-links.index',   'perm' => 'manage-social-links',  'icon' => 'fa-share-alt',        'title' => 'Réseaux sociaux',      'desc' => 'Liens affichés dans le pied de page et la page contact.'],
    ['route' => 'admin.languages.index',      'perm' => 'manage-languages',     'icon' => 'fa-language',         'title' => 'Langues',              'desc' => 'Langues proposées dans le sélecteur du site.'],
    ['route' => 'admin.currencies.index',     'perm' => 'manage-currencies',    'icon' => 'fa-money-bill-wave',  'title' => 'Devises',              'desc' => 'Devises disponibles dans les formulaires et le simulateur.'],
    ['route' => 'admin.loan-settings.edit',   'perm' => 'manage-loan-settings', 'icon' => 'fa-percentage',       'title' => 'Paramètres de prêt',   'desc' => 'Taux d\'intérêt, montants min/max et e-mail de notification.'],
  ];
@endphp

<div class="page-hdr">
  <h4>Bienvenue, {{ $user->name }}</h4>
  <p>Gérez les informations disponibles sur le site.</p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1rem">
  @foreach($tools as $t)
    @if($isSuper || $user->can($t['perm']))
    <a href="{{ route($t['route']) }}" class="card-pro" style="display:block;padding:1.25rem;text-decoration:none;color:inherit">
      <div style="font-size:1.4rem;color:var(--c-accent);margin-bottom:.5rem"><i class="fas {{ $t['icon'] }}"></i></div>
      <div style="font-weight:800;color:var(--c-navy);margin-bottom:.25rem">{{ $t['title'] }}</div>
      <div style="font-size:.8rem;color:var(--c-muted)">{{ $t['desc'] }}</div>
    </a>
    @endif
  @endforeach
  @if($isSuper)
  <a href="{{ route('super-admin.roles') }}" class="card-pro" style="display:block;padding:1.25rem;text-decoration:none;color:inherit">
    <div style="font-size:1.4rem;color:var(--c-accent);margin-bottom:.5rem"><i class="fas fa-shield-alt"></i></div>
    <div style="font-weight:800;color:var(--c-navy);margin-bottom:.25rem">Rôles &amp; Permissions</div>
    <div style="font-size:.8rem;color:var(--c-muted)">Attribuer les rôles et accorder des accès aux administrateurs.</div>
  </a>
  @endif
</div>
@endsection
