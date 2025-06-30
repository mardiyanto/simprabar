<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInitialTables extends Migration
{
    public function up()
    {
        // Tabel users
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => 50],
            'password' => ['type' => 'VARCHAR', 'constraint' => 100],
            'role'     => ['type' => 'ENUM', 'constraint' => ['admin', 'ruangan', 'it']],
            'nama'     => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        // Tabel ruangan
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'nama_ruangan' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ruangan');

        // Tabel barang
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'nama_barang'=> ['type' => 'VARCHAR', 'constraint' => 100],
            'ruangan_id' => ['type' => 'INT', 'unsigned' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ruangan_id', 'ruangan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('barang');

        // Tabel tiket
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'nomor_tiket'       => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'ruangan_id'        => ['type' => 'INT', 'unsigned' => true],
            'barang_id'         => ['type' => 'INT', 'unsigned' => true],
            'deskripsi_kerusakan' => ['type' => 'TEXT'],
            'deskripsi_perbaikan' => ['type' => 'TEXT', 'null' => true],
            'foto_kerusakan'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'foto_perbaikan'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'            => ['type' => 'ENUM', 'constraint' => ['Menunggu', 'Diproses', 'Selesai'], 'default' => 'Menunggu'],
            'hasil_perbaikan'   => ['type' => 'ENUM', 'constraint' => ['Diperbaiki', 'Service Center', 'Rusak Total'], 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'default' => 'CURRENT_TIMESTAMP'],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ruangan_id', 'ruangan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('barang_id', 'barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tiket');
    }

    public function down()
    {
        $this->forge->dropTable('tiket');
        $this->forge->dropTable('barang');
        $this->forge->dropTable('ruangan');
        $this->forge->dropTable('users');
    }
}
