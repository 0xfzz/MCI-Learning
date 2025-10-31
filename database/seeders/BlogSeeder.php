<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Seed the application's blog posts.
     */
    public function run(): void
    {
        Blog::updateOrCreate(
            ['slug' => 'membuat-rest-api-golang-dengan-echo'],
            [
                'title' => 'Membangun REST API Go dengan Echo dalam 15 Menit',
                'author' => 'Team MCI Learning',
                'content' => <<<'MD'
# Intro

Pada artikel ini kita akan membuat REST API sederhana menggunakan **Echo**, salah satu framework favorit di ekosistem Go.

## Persiapan

Pastikan Go sudah terpasang. Lanjut jalankan perintah berikut:

```bash
go mod init github.com/mci-learning/echo-rest
```

Selanjutnya instal Echo:

```bash
go get github.com/labstack/echo/v4
```

## Implementasi

Buat file `main.go` dengan konten berikut:

```go
package main

import (
    "net/http"

    "github.com/labstack/echo/v4"
)

type Course struct {
    ID   int    `json:"id"`
    Name string `json:"name"`
}

func main() {
    e := echo.New()

    e.GET("/courses", func(c echo.Context) error {
        courses := []Course{{ID: 1, Name: "Golang Dasar"}}
        return c.JSON(http.StatusOK, courses)
    })

    e.Logger.Fatal(e.Start(":8080"))
}
```

## Penutup

Sekarang jalankan:

```bash
go run main.go
```

API siap dan tombol salin kode di atas bisa langsung kamu gunakan untuk mempercepat copy paste snippet.
MD,
                'status' => 'published',
            ]
        );

        Blog::updateOrCreate(
            ['slug' => 'tips-markdown-editor-easymde'],
            [
                'title' => 'Tips Memaksimalkan Markdown Editor EasyMDE',
                'author' => 'Team MCI Learning',
                'content' => <<<'MD'
# Overview

EasyMDE memudahkan penulisan konten blog dengan pengalaman yang menyenangkan.

## Shortcuts Favorit

```markdown
**Bold** -> Ctrl + B
_Italic_ -> Ctrl + I
[Kode] -> Ctrl + K
```

## Menambah Blockquote

```markdown
> Jangan lupa tambahkan konteks pada kutipan agar pembaca paham maksudnya.
```

## Preview

Tekan tombol `Preview` di EasyMDE untuk melihat hasil akhir secara instan.
MD,
                'status' => 'published',
            ]
        );
    }
}
