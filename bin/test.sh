#!/usr/bin/env bash
# ユニットテストを実行する（app/Customize/Tests/ を対象、phpunit.xml を使用）。
#   bin/test.sh                      # 全テスト
#   bin/test.sh --filter testAddition
#   bin/test.sh --testdox
# 追加引数はそのまま phpunit へ渡る。
set -euo pipefail
cd "$(dirname "$0")/.."

docker compose exec -T ec-cube runuser -u www-data -- \
    php vendor/bin/phpunit -c phpunit.xml "$@"
