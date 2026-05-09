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
