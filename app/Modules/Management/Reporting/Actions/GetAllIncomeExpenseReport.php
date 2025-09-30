<?php

namespace App\Modules\Management\Reporting\Actions;

class GetAllIncomeExpenseReport
{
    static $ExpenseModel = \App\Modules\Management\AccountManagement\AccountExpense\Models\Model::class;
    static $IncomeModel = \App\Modules\Management\AccountManagement\AccountIncome\Models\Model::class;

    public static function execute()
    {
        try {

            $start_date = request()->start_date;
            $end_date = request()->end_date;

            $expenses = self::$ExpenseModel::query()
                ->with('account_category')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();

            $incomes = self::$IncomeModel::query()
                ->with('account_category')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->get();


            $totalIncome = $incomes->sum('amount');
            $totalExpense = $expenses->sum('amount');
            $surplus = $totalIncome - $totalExpense;

            // Prepare data for the table rows
            $rows = [];
            $maxRows = max($incomes->count(), $expenses->count());

            for ($i = 0; $i < $maxRows; $i++) {

                $rows[] = [
                    'income_category' => $incomes[$i]->account_category->title ?? '',
                    'income_amount' => $incomes[$i]->amount ?? '',
                    'expense_category' => $expenses[$i]->account_category->title ?? '',
                    'expense_amount' => $expenses[$i]->amount ?? '',
                ];
            }

            // Prepare the final data array
            $data = [
                'rows' => $rows,
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
                'surplus' => $surplus,
            ];

            return entityResponse($data);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
