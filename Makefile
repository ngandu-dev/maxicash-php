.DEFAULT_GOAL := help
.PHONY: help format lint typecheck test quality

help:
	@echo "format     Fix code style and automated refactors"
	@echo "lint       Check code style and automated refactors"
	@echo "typecheck  Run static analysis"
	@echo "test       Run the test suite"
	@echo "quality    Run all non-modifying checks"

format:
	composer format

lint:
	composer lint

typecheck:
	composer typecheck

test:
	composer test

quality:
	composer quality
