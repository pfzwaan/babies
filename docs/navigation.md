# Navegaciones (tipo WordPress)

Esta guia documenta como crear y renderizar navegaciones reutilizables desde Filament.

## 1. Crear navegacion en admin

1. Entra a `http://127.0.0.1:8000/admin/navigations`.
2. Clic en `Create Navigation`.
3. Llena campos:
   - `name`: nombre visible interno. Ejemplo: `Header Principal`.
   - `location`: clave tecnica para usar en Blade. Ejemplo: `header-menu`.
   - `status`: `draft` o `published`.
4. En `Menu Items`, agrega elementos con:
   - `label`: texto del link.
   - `type`:
     - `Page`: vincula una pagina publicada del CMS.
     - `Custom URL`: URL manual como `/contacto` o `https://...`.
   - `open_in_new_tab`: abrir en nueva pestana.
   - `children`: subitems (1 nivel).
5. Guarda. Si quieres que se muestre en frontend, deja `status = published`.

## 2. Renderizar una navegacion en Blade

El proyecto incluye el componente Blade:
- clase: `app/View/Components/SiteNavigation.php`
- vista: `resources/views/components/site-navigation.blade.php`

Uso basico:

```blade
<x-site-navigation location="header-menu" />
```

Con clases utilitarias:

```blade
<x-site-navigation
    location="header-menu"
    class="w-full border-b border-slate-200 py-4"
/>
```

## 3. Ejemplo en layout

Puedes colocarlo en tu layout principal (por ejemplo `resources/views/layouts/app.blade.php`):

```blade
<header>
    <x-site-navigation location="header-menu" class="container mx-auto px-4 py-3" />
</header>

<main>
    @yield('content')
</main>

<footer>
    <x-site-navigation location="footer-menu" class="container mx-auto px-4 py-8" />
</footer>
```

## 4. Comportamiento actual

- Solo renderiza navegaciones en `published`.
- Si `location` no existe o esta en draft, no imprime nada.
- En items `type = page`, solo enlaza paginas publicadas.
- Soporta items anidados a un nivel (`children`).

## 5. Estructura de datos

Tabla: `navigations`

Campos clave:
- `name` (string)
- `location` (string, unico)
- `status` (`draft|published`)
- `items` (json)

## 6. Ubicaciones recomendadas

Usa nombres consistentes para reutilizar:
- `header-menu`
- `footer-menu`
- `sidebar-menu`
- `legal-menu`

## 7. Troubleshooting rapido

- No se muestra menu:
  - Revisa que `status` sea `published`.
  - Revisa que `location` coincida exactamente con el valor en Blade.
- Item de tipo `Page` no aparece:
  - Verifica que esa pagina este en `published`.
- Cambios no se reflejan:
  - Ejecuta `C:\xampp\php\php.exe artisan optimize:clear`.
