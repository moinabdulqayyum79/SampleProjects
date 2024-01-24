package com.moin.sechallenge.repository;

import org.springframework.data.jpa.repository.JpaRepository;

import com.moin.sechallenge.model.JobGroup;

public interface JobGroupRepository extends JpaRepository<JobGroup, Integer> {

	long countByJobGroupName(String jobGroupName);
	JobGroup findByJobGroupName(String jobGroupName);
}
