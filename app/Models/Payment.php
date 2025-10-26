<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = "created_at";

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = "payment_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id",
        "course_id",
        "amount",
        "status",
        "bukti_transfer",
        "paid_at",
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "amount" => "integer",
            "paid_at" => "datetime",
            "created_at" => "datetime",
        ];
    }

    /**
     * Get the user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "user_id");
    }

    /**
     * Get the course that owns the payment.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, "course_id", "course_id");
    }

    /**
     * Mark the payment as successful.
     */
    public function markAsSuccess()
    {
        $this->update([
            "status" => "success",
            "paid_at" => now(),
        ]);
    }

    /**
     * Mark the payment as failed.
     */
    public function markAsFailed()
    {
        $this->update([
            "status" => "failed",
        ]);
    }

    /**
     * Check if the payment is pending.
     */
    public function isPending(): bool
    {
        return $this->status === "pending";
    }

    /**
     * Check if the payment is successful.
     */
    public function isSuccess(): bool
    {
        return $this->status === "success";
    }

    /**
     * Check if the payment is failed.
     */
    public function isFailed(): bool
    {
        return $this->status === "failed";
    }

    /**
     * Scope a query to only include pending payments.
     */
    public function scopePending($query)
    {
        return $query->where("status", "pending");
    }

    /**
     * Scope a query to only include successful payments.
     */
    public function scopeSuccess($query)
    {
        return $query->where("status", "success");
    }

    /**
     * Scope a query to only include failed payments.
     */
    public function scopeFailed($query)
    {
        return $query->where("status", "failed");
    }

}
