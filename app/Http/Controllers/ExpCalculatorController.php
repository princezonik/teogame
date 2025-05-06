<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpCalculatorController extends Controller
{
    public function showForm()
    {
        return view('exp_calculator');
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'current_exp' => 'required|integer|min:0',
            'target_level' => 'required|integer|min:1',
            'curve' => 'required|string|in:linear,exponential',
        ]);

        $currentExp = $validated['current_exp'];
        $targetLevel = $validated['target_level'];
        $curve = $validated['curve'];

        // Example formulas:
        $totalRequiredExp = match ($curve) {
            'linear' => $this->linearCurve($targetLevel),
            'exponential' => $this->exponentialCurve($targetLevel),
        };

        $remainingExp = max(0, $totalRequiredExp - $currentExp);

        return view('exp_calculator', [
            'current_exp' => $currentExp,
            'target_level' => $targetLevel,
            'curve' => $curve,
            'total_required_exp' => $totalRequiredExp,
            'remaining_exp' => $remainingExp,
        ]);
    }

    // EXP = 100 × level
    private function linearCurve(int $level): int
    {
        return $level * 100;
    }

    // EXP = 50 × level^2
    private function exponentialCurve(int $level): int
    {
        return (int)(50 * pow($level, 2));
    }
}
