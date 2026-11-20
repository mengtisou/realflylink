# Neon Coast (GTA V script mod)

An original single-player mod giving GTA V a bright, neon, sunset-coast feel.
It is **not** GTA 6 and contains no Rockstar assets.

## Features
| Key | Action |
|-----|--------|
| F7  | Lock golden-hour sunset + clear weather |
| F8  | Cycle neon underglow colours on your current car |
| F9  | Spawn a random sports car in front of you |
| F10 | Toggle a fun "followers" counter HUD |

## Install
1. Install [Script Hook V](http://www.dev-c.com/gtav/scripthookv/) and
   [Script Hook V .NET v3](https://github.com/scripthookvdotnet/scripthookvdotnet/releases).
2. Compile `NeonCoast.cs` (see below) or put `NeonCoast.cs` straight into
   `GTA V/scripts/` — SHVDN compiles `.cs` files automatically.
3. Start single-player and press F7-F10.

## Compile to a DLL (optional)
Create a Class Library targeting .NET Framework 4.8, reference
`ScriptHookVDotNet3.dll`, `System.Windows.Forms` and `System.Drawing`, build,
and copy the DLL into `GTA V/scripts/`.

Do not use in GTA Online (you risk a ban).
