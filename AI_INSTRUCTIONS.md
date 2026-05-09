# AI Utasítások

Ez a fájl tartalmazza az összes szükséges utasítást az AI (GitHub Copilot) számára ehhez a projekthez.

## Projekt információk

- **Keretrendszer**: Laravel 
- **Fejlesztői környezet**: Laravel Sail (Docker-alapú)
- **Adatbázis**: SQLite (fejlesztésben), MySQL (termelésben)
- **Frontend**: Vue.js + Vite
- **Nyelv**: PHP 8.x

## KRITIKUS: Sail parancsok használata

**Ez a projekt Docker + Sail-t használ. Minden parancsot Sailon keresztül kell futtatni!**

### Database/Adatbázis parancsok (MINDIG Sail-lel)

```bash
sail artisan migrate
sail artisan migrate:fresh
sail artisan migrate:fresh --seed
sail artisan migrate:rollback
sail artisan db:seed
sail artisan db:seed --class=SpecificSeeder
```

### Model, Controller, Migration, Seeder létrehozás (MINDIG Sail-lel)

```bash
sail artisan make:model ModelName
sail artisan make:migration migration_name
sail artisan make:seeder SeederName
sail artisan make:controller ControllerName
sail artisan make:request RequestName
```

### NPM/Frontend parancsok (MINDIG Sail-lel)

```bash
sail npm install
sail npm run dev
sail npm run build
sail npm run test
```

### Cache/Config parancsok

```bash
sail artisan cache:clear
sail artisan config:clear
sail artisan view:clear
```

## NE tegyél meg ezt soha:

- ❌ `php artisan ...` - Helyette: `sail artisan ...`
- ❌ `composer install` - Helyette: `sail composer install`
- ❌ `npm install` - Helyette: `sail npm install`
- ❌ `mysql` közvetlen parancs - Helyette: `sail mysql` vagy `sail artisan tinker`
- ❌ Direkt fájlok törlése migrations mappából - Használj `sail artisan migrate:rollback`

## Projektkészlet

### Database táblák

1. **users** - Felhasználók (már létezik)
2. **family_members** - Családtagok
   - id (PK)
   - name
   - email (nullable)
   - birth_date (nullable)
   - gender (enum: male, female, other)
   - description (nullable)
   - timestamps

3. **relationship_types** - Kapcsolat típusok
   - id (PK)
   - name (unique)
   - slug (unique)
   - description (nullable)
   - timestamps

4. **family_relationships** - Családtagok közötti kapcsolatok
   - id (PK)
   - family_member_1_id (FK → family_members, cascade)
   - family_member_2_id (FK → family_members, cascade)
   - relationship_type_id (FK → relationship_types, restrict)
   - notes (nullable)
   - timestamps
   - unique constraint: (family_member_1_id, family_member_2_id, relationship_type_id)

### Models

1. **App\Models\FamilyMember** - Családtag model
   - Kapcsolatok: relationshipsAsFirstMember(), relationshipsAsSecondMember(), relationships(), relatedMembers()

2. **App\Models\FamilyRelationship** - Kapcsolat model
   - Kapcsolatok: familyMember1(), familyMember2(), relationshipType()

3. **App\Models\RelationshipType** - Kapcsolat típus model
   - Kapcsolatok: familyRelationships()

### Seeders

1. **RelationshipTypeSeeder** - 14 alapértelmezett kapcsolat típust szúr be:
   - Parent, Child, Sibling, Spouse, Grandparent, Grandchild, Aunt, Uncle, Niece, Nephew, Cousin, In-law, Step-sibling, Step-parent

## Migrációk sorrendje

1. `create_relationship_types_table` - ELSŐ! Ez a szülő tábla
2. `create_family_members_table`
3. `create_family_relationships_table` - Utolsó, ide a FK-k

## Fejlesztői munkamenet elindítása

```bash
# 1. Indítsd el a Sailt
sail up -d

# 2. Futtasd a migrációkat és seedereket
sail artisan migrate:fresh --seed

# 3. Indítsd el az asset buildereket
sail npm run dev

# 4. A szerver fut: http://localhost
```

## Fájlstruktúra

```
/home/molitor/work/molitor/csaladfa/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   └── Models/
│       ├── FamilyMember.php
│       ├── FamilyRelationship.php
│       ├── RelationshipType.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   ├── 2026_05_09_095902_create_relationship_types_table.php
│   │   ├── 2026_05_09_095430_create_family_members_table.php
│   │   └── 2026_05_09_095430_create_family_relationships_table.php
│   └── seeders/
│       ├── RelationshipTypeSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   ├── web.php
│   └── console.php
├── SAIL.md (alapvető Sail utasítások)
└── AI_INSTRUCTIONS.md (ez a fájl)
```

## Packagek a projektben

### PHP packages

- Laravel Framework
- Laravel Sail
- PHPUnit
- Laravel Pint (Code style fixer)

### NPM packages

- Vue.js 3
- Vite
- Tailwind CSS (a packages/admin mappában)
- TypeScript

## Közös feladatok

### Új Family Member hozzáadása

```php
use App\Models\FamilyMember;

$member = FamilyMember::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'birth_date' => '1990-01-15',
    'gender' => 'male',
    'description' => 'Optional description'
]);
```

### Összeköts két Family Memberet

```php
use App\Models\FamilyRelationship;
use App\Models\RelationshipType;

$parentType = RelationshipType::where('slug', 'parent')->first();

FamilyRelationship::create([
    'family_member_1_id' => 1,
    'family_member_2_id' => 2,
    'relationship_type_id' => $parentType->id,
    'notes' => 'Optional notes about the relationship'
]);
```

### Lekérdezések

```php
// Egy tag összes kapcsolata
$member->relationships();

// Összes kapcsolódó tag
$member->relatedMembers();

// Kapcsolat típusok listája
RelationshipType::all();

// Egy tag összes szülő-gyermek kapcsolata
$member->relationshipsAsFirstMember()->get();
```

## Hibaelhárítás

### "Could not find driver" hiba

- Ez azt jelenti, hogy az adatbázis-kapcsolat nem megfelelő
- Győződj meg arról, hogy `sail artisan` parancsokat használsz, nem `php artisan`-t
- Futtasd: `sail artisan config:clear && sail artisan migrate`

### Migrációs konfliktusok

- Soha ne töröld manuálisan a migrációs fájlokat
- Használd: `sail artisan migrate:rollback`
- Utána pedig: `sail artisan migrate`

## További információk

Lásd: `/home/molitor/work/molitor/csaladfa/SAIL.md` a részletes Sail utasítások megtekintéséhez.

