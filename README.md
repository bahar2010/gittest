# CodeIgniter header-sent hotfix

This repository captures a small hotfix for the fatal error:

```
Cannot modify header information - headers already sent by ...
```

In older CodeIgniter 4.x releases the exception handler always calls
`header(...)` even when output has already started. That produces a second
ErrorException and masks the original error.

## Fix (hotfix patch)

Apply the patch below to the framework file in your project:

```
git apply patches/codeigniter4-exceptions-headers-sent.patch
```

The patch adds a `headers_sent()` guard around the header call.

## Also fix the root output source

The first "headers already sent" message always points at the real file
that started output (for example a stray BOM or debug `echo`). Remove that
output so headers can be set normally.

## Preferred long-term fix

Upgrade to a newer CodeIgniter release where the guard already exists.
