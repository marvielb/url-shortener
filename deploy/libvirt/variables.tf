variable "debian_image_url" {
  description = "debian 12 url"
  default     = "./images/debian-12-generic-amd64-20231013-1532.qcow2"
}

variable "vm_hostname" {
  description = "vm hostname"
  default     = "terraform-kvm"
}

variable "ssh_username" {
  description = "the ssh user to use"
  default     = "root"
}

variable "ssh_private_key" {
  description = "the private key to use"
  default     = "~/.ssh/id_rsa"
}
