CREATE SCHEMA SISIDANG;

SET SEARCH_PATH TO SISIDANG;

CREATE TABLE MAHASISWA (
	NPM CHAR(10) PRIMARY KEY,
	Nama VARCHAR(100) NOT NULL,
	Username VARCHAR(30) NOT NULL,
	Password VARCHAR(20) NOT NULL,
	Email VARCHAR(100) NOT NULL,
	Email_Alternatif VARCHAR(100),
	Telepon VARCHAR(100),
	NoTelp VARCHAR(100)
);

CREATE TABLE TERM (
	Tahun INT UNIQUE,
	Semester INT UNIQUE,
	PRIMARY KEY(Tahun, Semester)
);

CREATE TABLE PRODI (
	Id INT PRIMARY KEY,
	NamaProdi VARCHAR(50) NOT NULL UNIQUE
);
    
CREATE TABLE DOSEN (
	NIP VARCHAR(20) PRIMARY KEY,
	Nama VARCHAR(100) NOT NULL,
	Username VARCHAR(50) NOT NULL,
	Email VARCHAR(100) NOT NULL,
	Institusi VARCHAR(100) NOT NULL,
	Password VARCHAR (50) NOT NULL
);

CREATE TABLE JENIS_MKS (
	Id INT PRIMARY KEY,
	NamaMKS VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE MATA_KULIAH_SPESIAL (
	IdMKS INT UNIQUE,
	NPM CHAR(100),
	Tahun INT,
	Semester INT,
	Judul VARCHAR(250) NOT NULL,
	IsSiapSidang BOOLEAN DEFAULT FALSE,
	PengumpulanHardopy BOOLEAN DEFAULT FALSE,
	IzinMajuSidang BOOLEAN DEFAULT FALSE,
	IdJenisMKS INT NOT NULL,
	PRIMARY KEY(IdMKS, NPM, Tahun, Semester),
	FOREIGN KEY(NPM) REFERENCES MAHASISWA(NPM) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(Tahun, Semester) REFERENCES TERM(Tahun, Semester) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(IdJenisMKS) REFERENCES JENIS_MKS(Id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE DOSEN_PEMBIMBING (
	IdMKS INT,
	NIP_DosenPembimbing VARCHAR(20),
	PRIMARY KEY(IdMKS, NIP_DosenPembimbing),
	FOREIGN KEY(IdMKS) REFERENCES MATA_KULIAH_SPESIAL(IdMKS) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(NIP_DosenPembimbing) REFERENCES DOSEN(NIP) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE SARAN_DOSEN_PENGUJI (
	IdMKS INT,
	NIP_SaranPenguji VARCHAR(20),
	PRIMARY KEY(IdMKS, NIP_SaranPenguji),
	FOREIGN KEY(IdMKS) REFERENCES MATA_KULIAH_SPESIAL(IdMKS) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(NIP_SaranPenguji) REFERENCES DOSEN(NIP) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE DOSEN_PENGUJI (
	IdMKS INT,
	NIP_DosenPenguji VARCHAR(20),
	PRIMARY KEY(IdMKS, NIP_DosenPenguji),
	FOREIGN KEY(IdMKS) REFERENCES MATA_KULIAH_SPESIAL(IdMKS) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(NIP_DosenPenguji) REFERENCES DOSEN(NIP) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE TIMELINE (
	IdTimeline INT PRIMARY KEY,
	NamaEvent VARCHAR(100) NOT NULL,
	Tanggal DATE NOT NULL,
	Tahun INT NOT NULL,
	Semester INT NOT NULL,
	FOREIGN KEY(Tahun, Semester) REFERENCES TERM(Tahun, Semester) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE JADWAL_NON_SIDANG (
	IdJadwal INT PRIMARY KEY,
	TanggalMulai DATE NOT NULL,
	TanggalSelesai DATE NOT NULL,
	Alasan VARCHAR(100) NOT NULL,
	Repetisi VARCHAR(50),
	NIP_Dosen VARCHAR(20) NOT NULL,
	FOREIGN KEY(NIP_Dosen) REFERENCES DOSEN(NIP) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE RUANGAN (
	IdRuangan INT PRIMARY KEY,
	NamaRuangan VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE JADWAL_SIDANG (
	IdJadwal INT,
	IdMKS INT,
	Tanggal DATE NOT NULL,
	JamMulai TIME NOT NULL,
	JamSelesai TIME NOT NULL,
	IdRuangan INT NOT NULL,
	PRIMARY KEY (IdJadwal, IdMKS),
	FOREIGN KEY (IdMKS) REFERENCES MATA_KULIAH_SPESIAL(IdMKS) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (IdRuangan) REFERENCES RUANGAN(IdRuangan) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE BERKAS (
	IdBerkas INT,
	IdMKS INT,
	Nama VARCHAR(100) NOT NULL,
	Alamat VARCHAR(100) NOT NULL,
	PRIMARY KEY(IdBerkas, IdMKS),
	FOREIGN KEY(IdMKS) REFERENCES MATA_KULIAH_SPESIAL(IdMKS) ON DELETE CASCADE ON UPDATE CASCADE
);