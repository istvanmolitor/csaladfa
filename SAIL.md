# Laravel Sail használata

A projekt a jövőben a **Laravel Sail**-t használja a fejlesztői környezet futtatásához.

## Előfeltételek

- Docker Desktop vagy Docker Engine
- PHP és Composer (csak a kezdeti telepítéshez)

## Használat

A Sail parancsok futtatásához használható a vendor mappában lévő bináris:

```bash
./vendor/bin/sail up -d
```

### Alias beállítása (ajánlott)

Hogy ne kelljen mindig a teljes útvonalat kiírni, érdemes aliast beállítani a shell konfigurációs fájljában (`.bashrc` vagy `.zshrc`):

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

Ezután egyszerűen használható a `sail` parancs:

```bash
sail up -d
sail artisan migrate
sail npm run dev
```

## Leállítás

```bash
sail stop
```

## Az AI-nak

**FONTOS**: Ez a projekt Laravel Sailt használ a fejlesztői környezethez. A jövőben az alábbi parancsokat **KELL** használni:

### Migrációk futtatása

```bash
sail artisan migrate
sail artisan migrate:fresh
sail artisan migrate:fresh --seed
sail artisan migrate:rollback
```

### Seederek futtatása

```bash
sail artisan db:seed
sail artisan db:seed --class=RelationshipTypeSeeder
```

### Artisan parancsok

```bash
sail artisan make:model NévModell
sail artisan make:migration migration_neve
sail artisan make:seeder SeederName
sail artisan make:controller ControllerName
```

### NPM parancsok

```bash
sail npm install
sail npm run dev
sail npm run build
```

### Database parancsok

```bash
sail mysql
sail redis-cli
```

### Egyéb

```bash
sail up -d      # Indítás
sail stop       # Leállítás
sail shell      # Shell belépés a konténerbe
sail root-shell # Root shell belépés
```

**Soha ne használd a helyi `php artisan` parancsot vagy a helyi `npm` parancsot!**
**Mindig a `sail artisan` és `sail npm` parancsokat kell használni!**

