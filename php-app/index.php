<?php
// dice roller app - Max

declare(strict_types=1);

// Defaults
$qty   = 1;   // number of dice
$sides = 6;   // faces per die
$rolls = [];
$total = null;
$error = null;

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic input sanitising
    $qty   = isset($_POST['qty'])   ? (int)$_POST['qty']   : 1;
    $sides = isset($_POST['sides']) ? (int)$_POST['sides'] : 6;

    if ($qty < 1 || $qty > 20)   { $error = "Dice quantity must be 1–20."; }
    if ($sides < 2 || $sides > 1000) { $error = "Sides must be 2–1000."; }

    if (!$error) {
        $total = 0;
        for ($i = 0; $i < $qty; $i++) {
            // cryptographically secure uniform integer
            $val = random_int(1, $sides);
            $rolls[] = $val;
            $total  += $val;
        }
    }
}

function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>PHP Dice Roller</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  :root { --bg:#0b1020; --card:#111a2f; --fg:#e6edf3; --muted:#9aa6b2; --accent:#7aa2ff; --ok:#35c86d; --bad:#ff6b6b; }
  * { box-sizing: border-box; }
  body {
    margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    background: radial-gradient(1200px 600px at 50% -200px, #1a2444, #0b1020); color: var(--fg);
    min-height:100vh; display:grid; place-items:center; padding:24px;
  }
  .app { width:100%; max-width:640px; background: var(--card); border:1px solid #25314f;
         border-radius:16px; padding:18px; box-shadow: 0 18px 40px rgba(0,0,0,.35); }
  h1 { margin:0 0 8px; font-size:22px; }
  p.sub { margin:0 0 16px; color: var(--muted); font-size:13px; }
  form { display:grid; grid-template-columns: 1fr 1fr auto; gap:10px; align-items:end; }
  label { display:block; font-size:12px; color: var(--muted); margin-bottom:6px; }
  input[type=number] {
    width:100%; padding:10px 12px; border-radius:10px; border:1px solid #2e3a5f;
    background:#0f162b; color:var(--fg); outline:none;
  }
  button {
    padding:11px 14px; border-radius:10px; border:1px solid #304074; background: var(--accent);
    color:#06112b; font-weight:800; cursor:pointer; transition: transform .04s ease;
  }
  button:active { transform: translateY(1px); }
  .error { background:#2a1320; border:1px solid #5a2139; color:#ff9bb6; padding:10px 12px; border-radius:10px; margin-top:12px; }
  .results { margin-top:16px; }
  .row { display:flex; flex-wrap:wrap; gap:8px; margin-top:10px; }
  .die {
    min-width:42px; padding:8px 10px; border-radius:10px; background:#0f1a34; border:1px solid #283764;
    display:inline-flex; align-items:center; justify-content:center; font-weight:800;
  }
  .total { margin-top:12px; padding:10px 12px; border-radius:10px; border:1px solid #294560; background:#0d2031; }
  .hint { margin-top:12px; color: var(--muted); font-size:12px; }
  a.link { color:#9dc0ff; text-decoration:none; }
</style>
</head>
<body>
  <div class="app">
    <h1>🎲 PHP Dice Roller</h1>
    <p class="sub">Choose how many dice and how many sides. Click roll to get instant results.</p>

    <form method="post" action="">
      <div>
        <label for="qty">Dice (1–20)</label>
        <input id="qty" name="qty" type="number" min="1" max="20" value="<?=h((string)$qty)?>">
      </div>
      <div>
        <label for="sides">Sides per die (2–1000)</label>
        <input id="sides" name="sides" type="number" min="2" max="1000" value="<?=h((string)$sides)?>">
      </div>
      <div>
        <button type="submit">Roll 🎲</button>
      </div>
    </form>

    <?php if ($error): ?>
      <div class="error"><?= h($error) ?></div>
    <?php endif; ?>

    <?php if ($total !== null && !$error): ?>
      <div class="results">
        <div class="row">
          <?php foreach ($rolls as $i => $v): ?>
            <div class="die" title="Die #<?= $i+1 ?>"><?= (int)$v ?></div>
          <?php endforeach; ?>
        </div>
        <div class="total"><strong>Total:</strong> <?= (int)$total ?></div>
      </div>
    <?php endif; ?>


    </div>
  </div>
</body>
</html>
