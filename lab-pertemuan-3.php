<?php
// LAB 3 — Enkapsulasi
// Spesifikasi:
//  - Rekening(string $nomor, string $pemilik), properti PRIVATE $saldo = 0
//      setor(float $jumlah): bool   -> false jika jumlah <= 0
//      tarik(float $jumlah): bool   -> false jika jumlah > saldo
//      transfer(Rekening $tujuan, float $jumlah): bool
//      getSaldo(): float, getRiwayat(): array
//  - Siswa() dengan setNilai(int) (hanya 0–100) dan getNilai(): int
class Rekening
{
    private string $nomor;
    private string $pemilik;
    private float $saldo = 0;
    private array $riwayat = [];
    
    public function __construct(string $nomor, string $pemilik)
    {
        $this->nomor = $nomor;
        $this->pemilik = $pemilik;
        $this->riwayat[] = "Rekening {$nomor} ({$pemilik}) dibuat.";
    }

    public function setor(float $jumlah): bool
    {
        if ($jumlah <= 0) {
            return false;
        }
        
        $this->saldo += $jumlah; 
        $this->riwayat[] = "Setor: +{$jumlah} | Saldo: {$this->saldo}"; // Perbaikan: ubah teks menjadi Setor
        return true;
    } 
    
    public function tarik(float $jumlah): bool
    {
        if ($jumlah <= 0 || $jumlah > $this->saldo) {
            return false;
        }

        $this->saldo -= $jumlah;
        $this->riwayat[] = "Tarik: -{$jumlah} | Saldo: {$this->saldo}";
        return true;
    }

    public function transfer(Rekening $tujuan, float $jumlah): bool
    {
        if ($this->tarik($jumlah)) {
            $tujuan->setor($jumlah);
            $this->riwayat[] = "Transfer keluar {$jumlah} ke rekening {$tujuan->getNomor()} ({$tujuan->getPemilik()})";
            return true;
        }

        return false;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function getRiwayat(): array
    {
        return $this->riwayat;
    }

    public function getNomor(): string
    {
        return $this->nomor;
    }

    public function getPemilik(): string
    {
        return $this->pemilik;
    }
}

class Siswa
{
    private int $nilai = 0;

    public function setNilai(int $nilai): bool
    {
        if ($nilai < 0 || $nilai > 100) {
            return false;
        }

        $this->nilai = $nilai;
        return true;
    }

    public function getNilai(): int
    {
        return $this->nilai;
    }
}


$a = new Rekening('001', 'Andi');
$b = new Rekening('002', 'Budi');

$a->setor(100000);
echo "Saldo Andi: " . $a->getSaldo() . PHP_EOL; // 100000

$a->transfer($b, 35000);
echo "Saldo Andi setelah transfer: " . $a->getSaldo() . PHP_EOL; // 65000
echo "Saldo Budi setelah transfer: " . $b->getSaldo() . PHP_EOL; // 35000

print_r($a->getRiwayat());

$siswa = new Siswa();
$siswa->setNilai(85);
echo "Nilai Siswa: " . $siswa->getNilai() . PHP_EOL; // 85