package com.moin.sechallenge.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.moin.sechallenge.model.FileUpload;

@Repository
public interface FileRepository extends JpaRepository<FileUpload, Integer>{
	
}
