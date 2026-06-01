#!/usr/bin/env bash
# CI3 shop の export と Laravel12 shop の export を比較して diff を生成する。
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")/../../.." && pwd)"
EXAMPLE_DIR="${ROOT_DIR}/examples/laravel12-shop"
LEGACY="${ROOT_DIR}/examples/ci3-shop/var/export.json"
TARGET="${EXAMPLE_DIR}/var/export.json"

if [ ! -f "${LEGACY}" ]; then
  echo "Error: ${LEGACY} not found. Run ci3-shop E2E + analyze first." >&2
  exit 1
fi
if [ ! -f "${TARGET}" ]; then
  echo "Error: ${TARGET} not found. Run laravel12-shop E2E + analyze.sh first." >&2
  exit 1
fi

php "${ROOT_DIR}/bin/tekagami" diff "${LEGACY}" "${TARGET}" --format md   > "${EXAMPLE_DIR}/var/diff.md"
echo "wrote ${EXAMPLE_DIR}/var/diff.md"

php "${ROOT_DIR}/bin/tekagami" diff "${LEGACY}" "${TARGET}" --format json > "${EXAMPLE_DIR}/var/diff.json"
echo "wrote ${EXAMPLE_DIR}/var/diff.json"
