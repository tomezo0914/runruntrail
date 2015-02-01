# config valid only for current version of Capistrano
lock '3.3.5'

set :application, 'runruntrail'
set :repo_url, 'git@github.com:tomezo0914/runruntrail.git'

# Default branch is :master
# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }.call
set :branch, 'master'

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, "/var/www/html/#{fetch(:application)}"

# Default value for :scm is :git
set :scm, :git

# Default value for :format is :pretty
# set :format, :pretty

# Default value for :log_level is :debug
set :log_level, :debug

# Default value for :pty is false
set :pty, true

# Default value for :linked_files is []
set :linked_files, fetch(:linked_files, []).push('wp-config.php')

# Default value for linked_dirs is []
# set :linked_dirs, fetch(:linked_dirs, []).push('bin', 'log', 'tmp/pids', 'tmp/cache', 'tmp/sockets', 'vendor/bundle', 'public/system')

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
set :keep_releases, 5

namespace :deploy do

  desc "Upload important files"
  task :upload do
    on roles(:app) do |host|
      upload!("wp-config.php", "#{shared_path}/wp-config.php")
    end
  end
  before :started, "deploy:upload"

  after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    end
  end

end
